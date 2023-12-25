<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class LoginController extends AbstractController {

	#[Route('/logout', name: 'app_logout', methods: ['GET'])]
	public function logout() {
		// controller can be blank: it will never be called!
		throw new \LogicException('Don\'t forget to activate logout in security.yaml');
	}

	#[Route('/login', name: 'app_login')]
	public function index(): Response {
		return $this->render('security/login.html.twig');
	}

}
