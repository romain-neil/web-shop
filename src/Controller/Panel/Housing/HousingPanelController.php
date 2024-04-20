<?php
namespace App\Controller\Panel\Housing;

use App\Controller\Panel\PanelInterface;
use App\Controller\Panel\ServicePanelController;
use App\Repository\Services\Housing\HousingServiceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/panel/housing', name: 'panel_housing_')]
#[IsGranted('ROLE_USER')]
class HousingPanelController extends ServicePanelController implements PanelInterface {

	public function __construct(
		MailerInterface $mailer,
		EntityManagerInterface $em,
		private readonly HousingServiceRepository $housingRepo
	) {
		parent::__construct($mailer, $em);
	}

	#[Route('/{id}/show', name: 'show', methods: ['GET'])]
	public function show(int $id, Request $request): Response {
		$service = $this->housingRepo->findOneBy(['id' => $id]);

		if ($service === null) {
			$this->addFlash('negative', "Cette ressource n'existe pas");

			return $this->redirectToRoute('panel_home');
		}

		if ($service->getCustomer() !== $this->getUser()) {
			$this->addFlash('negative', "Vous n'avez pas l'autorisation d'afficher cette ressource");

			return $this->redirectToRoute('panel_home');
		}

		return $this->render('pages/panel/housing/show.html.twig', ['service' => $service]);
	}

	public function config(int $id, Request $request): Response {
		// TODO: Implement config() method.
	}

}
