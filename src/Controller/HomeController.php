<?php

namespace App\Controller;

use App\Service\ContactService;
use App\Form\ContactType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Routing\Attribute\Route;

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
	public function contact(Request $request, ContactService $contactService): Response {
		$form = $this->createForm(ContactType::class);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$data = $form->getData();

			try {
				$contactService->sendContactEmail($data, $request->getClientIp());
				$this->addFlash('success', 'Le message a été envoyé. Merci');

				return $this->redirectToRoute('home_contact');
			} catch (TransportExceptionInterface) {
				$this->addFlash('negative', 'Une erreur est survenue lors de l\'envoie du message. Merci de réessayer plus tard');
			}
		}

		return $this->render('pages/contact.html.twig', ['form' => $form->createView()]);
	}

}
