<?php
namespace App\Controller\Panel;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Interface used to indicate that a service will have a panel
 */
interface PanelInterface {

	/**
	 * Service initial configuration page
	 * Can be used on re-installation
	 * @param int $id
	 * @param Request $request
	 * @return Response
	 */
	public function onboarding(int $id, Request $request): Response;
	
	/**
	 * Show the service information page
	 * @param int $id
	 * @param Request $request
	 * @return Response
	 */
	public function show(int $id, Request $request): Response;

}
