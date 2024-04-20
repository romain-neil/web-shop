<?php
namespace App\Controller\Panel;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

interface PanelInterface {

	public function show(int $id, Request $request): Response;

}
