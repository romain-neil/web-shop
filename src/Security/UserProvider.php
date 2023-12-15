<?php

namespace App\Security;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\User;
use Symfony\Component\HttpFoundation\File\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserProvider implements UserProviderInterface {

	private EntityManagerInterface $em;

	public function __construct(ManagerRegistry $doctrine) {
		$this->em = $doctrine->getManager('intranet');
	}

	public function refreshUser(UserInterface $user): UserInterface {
		return $user;
	}

	public function supportsClass(string $class): bool {
		return is_subclass_of($class, User::class);
	}

	public function loadUserByIdentifier(string $identifier): UserInterface {
		$user = $this->em->getRepository(User::class)->findOneBy(['email' => $identifier]);

		if ($user == null || !($user instanceof User)) {
			throw new AccessDeniedException('Compte inexistant');
		}

		if (!$user->getIsActivated()) {
			throw new AccessDeniedException("Votre compte n'est pas activé");
		}

		return $user;
	}
}
