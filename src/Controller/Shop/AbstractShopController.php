<?php

namespace App\Controller\Shop;

use Symfony\Component\HttpFoundation\Response;

/**
 * The goal of this class is to provide common methods for shop controllers
 */
abstract class AbstractShopController extends ShopController {
	
	/**
	 * Show the landing page
	 * @return Response
	 */
	abstract public function landingPage(): Response;
	
	/**
	 * Show the select plan page
	 * @return Response
	 */
	abstract public function selectPlan(): Response;

}
