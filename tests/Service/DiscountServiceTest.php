<?php
namespace App\Tests\Service;

use App\Entity\Discount;
use App\Entity\DiscountCodeUsage;
use App\Entity\Order;
use App\Repository\DiscountCodeUsageRepository;
use App\Service\DiscountService;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class DiscountServiceTest extends TestCase {

    private function makeService(?MockObject $repo = null): DiscountService {
        /** @var DiscountCodeUsageRepository&MockObject $repo */
        $repo = $repo ?? $this->createMock(DiscountCodeUsageRepository::class);
        return new DiscountService($repo);
    }

    private function makeDiscount(array $opts = []): Discount {
        $d = new Discount();
        $d->setCode($opts['code'] ?? 'CODE');
        $d->setAmount($opts['amount'] ?? 1000); // cents
        $d->setIsPercent($opts['is_percent'] ?? false);
        $d->setAllowMultipleUse($opts['allow_multiple'] ?? false);
        $d->setMinimumOrderAmount($opts['min'] ?? null);
        $d->setMaximalTotalUsage($opts['max'] ?? null);
        return $d;
    }

    private function makeOrderStub(int $total, array $codeUsages): Order {
        /** @var Order&MockObject $order */
        $order = $this->createMock(Order::class);
        $order->method('getTotal')->willReturn($total);
        $order->method('getDiscountCodeUsages')->willReturn(new ArrayCollection($codeUsages));
        return $order;
    }

    public function test_cannot_apply_when_already_used_in_order_and_multiple_not_allowed(): void {
        $discount = $this->makeDiscount(['allow_multiple' => false]);

        $usage = new DiscountCodeUsage();
        $usage->setCode($discount); // same instance to trigger identity check

        $order = $this->makeOrderStub(10000, [$usage]);

        $repo = $this->createMock(DiscountCodeUsageRepository::class);
        $repo->method('findBy')->willReturn([]); // repository result won't be reached due to early return

        $service = $this->makeService($repo);
        $this->assertFalse($service->canApply($discount, $order));
    }

    public function test_can_apply_when_multiple_allowed_even_if_present_in_order(): void {
        $discount = $this->makeDiscount(['allow_multiple' => true]);

        $usage = new DiscountCodeUsage();
        $usage->setCode($discount);

        $order = $this->makeOrderStub(10000, [$usage]);

        $repo = $this->createMock(DiscountCodeUsageRepository::class);
        $repo->method('findBy')->willReturn([]);

        $service = $this->makeService($repo);
        $this->assertTrue($service->canApply($discount, $order));
    }

    public function test_cannot_apply_when_minimum_order_amount_greater_than_total(): void {
        $discount = $this->makeDiscount(['min' => 20000]);
        $order = $this->makeOrderStub(10000, []);

        $repo = $this->createMock(DiscountCodeUsageRepository::class);
        $repo->method('findBy')->willReturn([]);

        $service = $this->makeService($repo);
        $this->assertFalse($service->canApply($discount, $order));
    }

    public function test_can_apply_when_repository_returns_null_usage_list(): void {
        $discount = $this->makeDiscount();
        $order = $this->makeOrderStub(10000, []);

        $repo = $this->createMock(DiscountCodeUsageRepository::class);
        // Simulate null as coded path in service
        $repo->method('findBy')->willReturn(null);

        $service = $this->makeService($repo);
        $this->assertTrue($service->canApply($discount, $order));
    }

    public function test_returns_false_when_max_usage_check_triggers(): void {
        // According to current service condition, it returns false when max > -1 and max >= count(usages)
        $discount = $this->makeDiscount(['max' => 5]);
        $order = $this->makeOrderStub(10000, []);

        $usages = [new DiscountCodeUsage(), new DiscountCodeUsage(), new DiscountCodeUsage()];

        $repo = $this->createMock(DiscountCodeUsageRepository::class);
        $repo->method('findBy')->willReturn($usages);

        $service = $this->makeService($repo);
        $this->assertFalse($service->canApply($discount, $order));
    }

    public function test_can_apply_when_unlimited_usage(): void {
        $discount = $this->makeDiscount(['max' => DiscountService::UNLIMITED_USAGE]);
        $order = $this->makeOrderStub(10000, []);

        $usages = array_fill(0, 50, new DiscountCodeUsage());

        $repo = $this->createMock(DiscountCodeUsageRepository::class);
        $repo->method('findBy')->willReturn($usages);

        $service = $this->makeService($repo);
        $this->assertTrue($service->canApply($discount, $order));
    }
}
