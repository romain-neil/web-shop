<?php
namespace App\Controller\Shop;

use App\Controller\AController;
use App\Entity\AbstractService;
use App\Entity\Customer;
use App\Entity\Discount;
use App\Entity\DiscountCodeUsage;
use App\Entity\Order;
use App\Entity\Services\AbstractServicePlan;
use App\Entity\Services\VirtualMachine\VmPlan;
use App\Entity\Services\VirtualMachine\VmService;
use App\Entity\Services\Wireguard\WgPlan;
use App\Entity\Services\Wireguard\WireguardService;
use App\Service\DiscountService;
use App\Service\ShoppingService;
use DateTime;
use DateTimeZone;
use Exception;
use Symfony\Component\Clock\ClockInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

#[Route('/shop', name: 'shop_')]
#[IsGranted('ROLE_USER')]
class ShopController extends AController {

	/**
	 * Function used to retrieve service plan related to service type
	 * @param string $serviceType
	 * @param int $id
	 * @return \App\Entity\Services\AbstractServicePlan|null
	 */
	private function getServicePlan(string $serviceType, int $id): ?AbstractServicePlan {
		$planClass = match($serviceType) {
			'vm' => VmPlan::class,
			'wg' => WgPlan::class
		};

		$planDetails = $this->getRessource($planClass, $id);

		if ($planDetails == null) {
			throw new \InvalidArgumentException('No plan were found');
		}

		return $planDetails;
	}

	private function getService(string $serviceType): AbstractService {
		return match($serviceType) {
			'vm' => new VmService(),
			'wg' => new WireguardService()
		};
	}

	/**
	 * Function to apply the plan to the service
	 *
	 * @param Request $request
	 * @param AbstractServicePlan $plan the service plan
	 * @param string $serviceType the service type
	 * @return void
	 * @throws Exception
	 */
	protected function placeServiceOrder(Request $request, AbstractServicePlan $plan, string $serviceType): void {
		/** @var Customer $customer */
		$user = $this->getUser();

		$customer = $this->em->getRepository(Customer::class)->findOneBy(['id' => $user->getId()]);

		$order = $this->getOrder();
		if ($order == null) {
			$order = $this->createOrder($request);
		}

		$service = $this->getService($serviceType);
		$service->setPlan($plan);
		$service->setCustomer($customer);
		$service->setInternalServiceName($plan->getCommercialName());
		$service->setRelatedOrder($order);

		$this->em->persist($service);
		$this->em->flush();
	}

	#[Route('/', name: 'main')]
	public function mainPage(): Response {
		return $this->render('pages/shop/index.html.twig');
	}

    /**
     * @throws Exception
     */
	public function createOrder(Request $request): Order {
		/** @var Customer $customer */
		$customer = $this->getUser();

		$order = new Order();
        $order->setDateCreated(new DateTime('now', new DateTimeZone('UTC')));
		$order->setCustomer($customer);
        $order->setPaid(false);
        $order->setInCart(true);

		$this->em->persist($order);
		$this->em->flush();

		$request->getSession()->set('orderId', $order->getId());

		return $order;
	}

	/**
	 * @throws \Exception
	 */
	#[Route('/{service}/place-order/{id}', name: 'place_order')]
	public function placeOrder(Request $request, string $service, int $id): Response {
		try {
			$plan = $this->getServicePlan($service, $id);
		} catch (\InvalidArgumentException) {
			$this->addFlash('error', "Ce service n'existe pas");

			return $this->redirectToRoute('shop_' . $service . '_select_plan');
		}

		$this->placeServiceOrder($request, $plan, $service);

		return $this->redirectToRoute('shop_cart');
	}

    #[Route('/cart', name: 'cart')]
    public function showCart(): Response {
        $order = $this->getOrder();

        if ($order == null) {
            return $this->redirectToRoute('shop_main');
        }

        return $this->render('pages/shop/order_recap.html.twig', ['order' => $order, 'total' => $order->getTotal(), 'discounts' => $order->getDiscountCodeUsages()]);
    }

	#[Route('/cart/discount', name: 'apply_discount_code', methods: ['POST'])]
	public function applyDiscountCode(Request $request, DiscountService $discountService, ClockInterface $clock): RedirectResponse {
		$order = $this->getOrder();

		if ($order === null) {
			return $this->redirectToRoute('shop_main');
		}

		$code = $request->request->getString('discount-code');
		$discount = $this->em->getRepository(Discount::class)->findOneBy(['code' => $code]);

		if ($discount === null) {
			$this->addFlash('info', "Ce code de réduction n'existe pas");

			return $this->redirectToRoute('shop_cart');
		}

		if ($discountService->canApply($discount, $order)) {
			$discountUsage = new DiscountCodeUsage();
			$discountUsage->setCode($discount);
			$discountUsage->setDateUsage($clock->now());

			$order->addDiscountCodeUsage($discountUsage);

			$this->em->persist($discountUsage);
			$this->em->flush();

			$this->addFlash('info', 'Réduction appliquée');
		} else {
			$this->addFlash('info', "Le code ne s'applique pas à la commande");
		}

		return $this->redirectToRoute('shop_cart');
	}

	/**
	 * @throws \Exception|TransportExceptionInterface
	 */
	#[Route('/process', name: 'process_payment')]
	public function processPayment(ShoppingService $service): RedirectResponse {
		$order = $this->getOrder();

		if ($order == null) {
			return $this->redirectToRoute('shop_main');
		}

		if ($order->getServices()->count() == 0) {
			return $this->redirectToRoute('shop_main');
		}

		return $this->redirect($service->persistOrder($order));
	}

    public function getOrder(): ?Order {
		return $this->em->getRepository(Order::class)->findOneBy(['in_cart' => true, 'paid' => false, 'customer' => $this->getUser()]);
    }

}
