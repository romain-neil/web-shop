<?php
namespace App\Service;

use App\Entity\Discount;
use App\Entity\Order;
use App\Repository\DiscountCodeUsageRepository;

class DiscountService {

	public const int UNLIMITED_USAGE = -1;

	private DiscountCodeUsageRepository $repo;

	public function __construct(DiscountCodeUsageRepository $repo) {
		$this->repo = $repo;
	}

	/**
	 * Does the given discount can be applied to the specified order ?
	 * @param Discount $discount
	 * @param Order $order
	 * @return bool
	 */
	public function canApply(Discount $discount, Order $order): bool {
		//Check if code is allowed to be used multiple times in current order
		if (!$discount->isAllowMultipleUse()) {
			$codeUsages = $order->getDiscountCodeUsages();

			foreach ($codeUsages as $codeUsage) {
				if ($codeUsage->getCode() === $discount) {
					return false;
				}
			}
		}

		$min = $discount->getMinimumOrderAmount();
		if ($min != null && $min > $order->getTotal()) {
			return false;
		}

		//Get code usage
		$usage = $this->repo->findBy(['code' => $discount]);
		if ($usage === null) {
			return true;
		}

		// Maximum code usage
		if (
			$discount->getMaximalTotalUsage() > self::UNLIMITED_USAGE &&
			$discount->getMaximalTotalUsage() >= count($usage)
		) {
			return false;
		}

		return true;
	}

}
