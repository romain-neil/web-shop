<?php
namespace App\Controller\Panel;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Interface used to indicate that a service will have some configuration
 */
interface ConfigurablePanelInterface {
	
	/**
	 * Show the configuration page
	 * @param int $id
	 * @param Request $request
	 * @return Response
	 */
	public function config(int $id, Request $request): Response;
	
	/**
	 * Page to download the configuration file
	 * @param int $id
	 * @param Request $request
	 * @return Response
	 */
	public function downloadConfig(int $id, Request $request): Response;

}
