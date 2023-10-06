<?php

namespace App\Service;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

class ContactService {

	private MailerInterface $mailer;

	public function __construct(MailerInterface $mailer) {
		$this->mailer = $mailer;
	}

	/**
	 * @throws TransportExceptionInterface
	 */
	public function sendContactEmail(array $data, string $ip = ''): void {
		$replyEmail = $data['email'];

		if (!filter_var($replyEmail, FILTER_VALIDATE_EMAIL)) {
			$replyEmail = '';
		}

		$email = (new TemplatedEmail())
			->from('no-reply@shop.carow.fr')
			->to(new Address('contact@romain-neil.fr', 'Romain Neil'))
			->replyTo($replyEmail)
			->subject('[shop.carow.fr] Nouveau message du formulaire de contact')
			->htmlTemplate('emails/contact/new_message.html.twig')
			->context(['data' => $data, 'ip' => $ip])
		;

		$this->mailer->send($email);
	}

}
