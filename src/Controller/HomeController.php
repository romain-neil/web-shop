<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/', name: 'home_')]
class HomeController extends AController {

	#[Route('', name: 'index')]
	public function home(): Response {
		return $this->render('base.html.twig');
	}

	#[Route('/legal', name: 'legal')]
	public function legal(): Response {
		return $this->render('pages/legal.html.twig');
	}

	#[Route('/contact', name: 'contact')]
	public function contact(): Response {}

}
