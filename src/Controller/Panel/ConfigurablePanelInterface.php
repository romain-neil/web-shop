<?php
namespace App\Controller\Panel;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Interface used to indicate that service will have some configuration
 */
interface ConfigurablePanelInterface {

	public function config(int $id, Request $request): Response;

	public function downloadConfig(int $id, Request $request): Response;

}
