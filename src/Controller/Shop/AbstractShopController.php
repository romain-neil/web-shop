<?php

namespace App\Controller\Shop;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractShopController extends ShopController {

	abstract public function landingPage(): Response;

	abstract public function selectPlan(): Response;

    abstract public function placeOrder(int $id, Request $request): Response;

}
