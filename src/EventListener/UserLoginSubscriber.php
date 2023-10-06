<?php
namespace App\EventListener;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Http\Event\LoginSuccessEvent;

class UserLoginSubscriber implements EventSubscriberInterface {

	private EntityManagerInterface $em;

	public function __construct(EntityManagerInterface $manager) {
		$this->em = $manager;
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
