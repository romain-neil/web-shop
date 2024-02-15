<?php
namespace App\Controller\Panel;

use App\Entity\Customer;
use App\Controller\AController;
use App\Entity\Order;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/panel', name: 'panel_')]
#[IsGranted('ROLE_USER')]
class ServicePanelController extends AController {

	private function getCustomerServices(Customer $customer): array {
		return $this->em->getRepository(Order::class)->findBy(['customer' => $customer, 'in_cart' => false, 'paid' => true]);
	}

	#[Route('/', name: 'home')]
	public function home(): Response {
		/** @var User $user */
		$user = $this->getUser();

		if (!($user instanceof Customer)) {
			return $this->redirectToRoute('home_index');
		}

		$orders = $this->getCustomerServices($user);

		return $this->render('pages/panel/home.html.twig', ['orders' => $orders]);
	}

}
