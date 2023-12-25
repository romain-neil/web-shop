<?php

namespace App\Controller\Shop;

use App\Entity\Services\VirtualMachine\VmPlan;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/shop/vm', name: 'shop_vm_')]
#[IsGranted('ROLE_USER')]
class VmShopController extends AbstractShopController {

    #[Route('/', name: 'landing')]
    public function landingPage(): Response {
        //return $this->render('pages/shop/vm/');
        return $this->redirectToRoute('shop_vm_select_plan');
    }

    #[Route('/select-plan', name: 'select_plan')]
    public function selectPlan(): Response {
        //Show pricing table
        /** @var VmPlan[] $plans */
        $plans = $this->getAll(VmPlan::class);

        return $this->render('pages/shop/vm/pricing.html.twig', ['plans' => $plans]);
    }

}
