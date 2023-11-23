<?php

namespace App\Controller\Shop;

use App\Entity\Customer;
use App\Entity\Services\VirtualMachine\VmPlan;
use App\Entity\Services\VirtualMachine\VmService;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
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

    /**
     * @throws Exception
     */
    #[Route('/place-order/{id}', name: 'place_order', methods: ['GET'])]
    public function placeOrder(int $id, Request $request): Response {
        /** @var ?VmPlan $planDetails */
        $planDetails = $this->getRessource(VmPlan::class, $id);

        if ($planDetails == null) {
            return $this->redirectToRoute('shop_vm_select_plan');
        }

	    $order = $this->createOrder($request);

	    /** @var Customer $customer */
	    $customer = $this->getUser();

        $vm = new VmService();
        $vm->setPlan($planDetails);
		$vm->setCustomer($customer);
        $vm->setInternalServiceName('vm');
        $vm->setRelatedOrder($order);

        $this->em->persist($vm);
        $this->em->flush();

        return $this->redirectToRoute('shop_cart');
    }

}
