<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;

class AController extends AbstractController {

	protected MailerInterface $mailer;

	protected EntityManagerInterface $em;

	public function __construct(MailerInterface $mailer, EntityManagerInterface $em) {
		$this->mailer = $mailer;
		$this->em = $em;
	}

	public function getSession(): SessionInterface {
		return $this->session;
	}

}
