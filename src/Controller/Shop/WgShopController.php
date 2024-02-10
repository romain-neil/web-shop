<?php
namespace App\Controller\Shop;

use App\Entity\Services\Wireguard\WgPlan;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/shop/wg', name: 'shop_wg_')]
//#[IsGranted('ROLE_USER')]
class WgShopController extends AbstractShopController {

	#[Route('/', name: 'landing')]
	public function landingPage(): Response {
		return $this->redirectToRoute('shop_wg_select_plan');
	}

	#[Route('/select-plan', name: 'select_plan')]
	public function selectPlan(): Response {
		/** @var WgPlan[] $plans */
		$plans = $this->getAll(WgPlan::class);

		return $this->render('common/pages/shop/pricing.html.twig', ['plans' => $plans, 'ctrl' => 'wg']);
	}

}
