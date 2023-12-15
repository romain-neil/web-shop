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

	/**
	 * Return a ressource with the given id
	 * @param string $name
	 * @param int $id
	 * @return object|null
	 */
	public function getRessource(string $name, int $id): ?object {
		return $this->em->getRepository($name)->findOneBy(['id' => $id]);
	}

	public function getAll(string $name): ?array {
		return $this->em->getRepository($name)->findAll();
	}

}
