<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class AController extends AbstractController {

	private SessionInterface $session;

	public function __construct(RequestStack $requestStack) {
		$this->session =$requestStack->getSession();
	}

	public function getSession(): SessionInterface {
		return $this->session;
	}

}
