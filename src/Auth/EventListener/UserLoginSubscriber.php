<?php

namespace Auth\EventListener;

use Auth\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Http\Event\LoginSuccessEvent;

class UserLoginSubscriber implements EventSubscriberInterface {

	private EntityManagerInterface $em;

	public function __construct(EntityManagerInterface $em) {
		$this->em = $em;
	}

	public static function getSubscribedEvents(): array {
		return [
			LoginSuccessEvent::class => 'onLoginSuccess'
		];
	}

	public function onLoginSuccess(LoginSuccessEvent $event): void {
		/** @var User $user */
		$user = $event->getUser();

		$session = $event->getRequest()->getSession();
		$session->set('lastLoginDate', $user->getLastLoginDate());

		$user->setLastLoginDate(new \DateTime('now'));

		$this->em->persist($user);
		$this->em->flush();
	}

}
