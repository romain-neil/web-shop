<?php
namespace App\Security;

use Auth\Entity\User;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAccountStatusException;
use Symfony\Component\Security\Core\Exception\DisabledException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserChecker implements UserCheckerInterface {

	public function checkPreAuth(UserInterface $user): void {
		if(!$user instanceof User) {
			return;
		}

		if(!$user->getIsActivated()) {
			throw new CustomUserMessageAccountStatusException("Le compte n'est pas activé. Merci de cliquer sur le lien de première connexion");
		}
	}

	public function checkPostAuth(UserInterface $user): void {
		if(!$user instanceof User) {
			return;
		}

		if(!$user->getIsActivated()) {
			throw new DisabledException();
		}
	}
}
