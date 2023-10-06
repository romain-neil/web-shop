<?php
namespace App\Controller\Shop;

use App\Controller\AController;
use App\Entity\Customer;
use App\Entity\Order;
use App\Service\ShoppingService;
use DateTime;
use DateTimeZone;
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/shop', name: 'shop_')]
#[IsGranted('ROLE_USER')]
class ShopController extends AController {

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

    #[Route('/cart', name: 'cart')]
    public function showCart(Request $request): Response {
        $order = $this->getOrder($request);

        if ($order == null) {
            return $this->redirectToRoute('shop_main');
        }

        return $this->render('pages/shop/order_recap.html.twig', ['order' => $order, 'total' => $order->getTotal()]);
    }

	/**
	 * @throws GuzzleException
	 */
	#[Route('/process', name: 'process_payment')]
	public function processPayment(Request $request, ShoppingService $service): RedirectResponse {
		$order = $this->getOrder($request);

		if ($order == null) {
			return $this->redirectToRoute('shop_main');
		}

		if ($order->getServices()->count() == 0) {
			return $this->redirectToRoute('shop_main');
		}

		return $this->redirect($service->persistOrder($order));
	}

    public function getOrder(Request $request): ?Order {
        $session = $request->getSession();

        return $this->getRessource(Order::class, $session->get('orderId', 0));
    }

}
