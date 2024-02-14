<?php

namespace App\Controller\Panel\Vm;

use App\Controller\Panel\PanelInterface;
use App\Controller\Panel\ServicePanelController;
use App\Entity\Customer;
use App\Entity\Services\VirtualMachine\OsDistribution;
use App\Entity\Services\VirtualMachine\VmService;
use App\Service\Connector\VmConnector;
use Doctrine\ORM\EntityManagerInterface;
use Override;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/panel/vm', name: 'panel_vm_')]
#[IsGranted('ROLE_USER')]
class VmPanelController extends ServicePanelController implements PanelInterface {

	protected VmConnector $vmConnector;

	public function __construct(
		MailerInterface $mailer,
		EntityManagerInterface $em,
		VmConnector $vmConnector
	) {
		parent::__construct($mailer, $em);

		$this->vmConnector = $vmConnector;
	}

	private function getVm(int $id): ?VmService {
		return $this->getRessource(VmService::class, $id);
	}

	#[Route('/{id}/onboard', name: 'onboarding')]
	public function onboarding(int $id, Request $request): Response {
		$vm = $this->getVm($id);

		/** @var OsDistribution $allOs */
		$allOs = $this->getAll(OsDistribution::class);

		return $this->render('pages/panel/vm/onboarding.html.twig', ['os' => $allOs]);
	}

	/**
	 * Install the specified vm with the specified system
	 *
	 * @param Request $request
	 * @param VmConnector $vmConnector
	 * @return Response
	 */
	#[Route('/install', name: 'install', methods: ['POST'])]
	public function install(Request $request, VmConnector $vmConnector): Response {
		$operatingSystemId = $request->request->getInt('osId');
		$vmId = $request->request->getInt('vmId');

		/** @var Customer $customer */
		$customer = $this->getUser();

		$vm = $this->getVm($vmId);
		if ($vm == null) {
			$this->addFlash('warning', "Cette ressource n'existe pas");

			return $this->redirectToRoute('panel_home');
		}

		if ($vm->getCustomer() !== $customer) {
			$this->addFlash('negative', "Vous n'êtes pas autorisés à afficher cette ressource");

			return $this->redirectToRoute('panel_home');
		}

		/** @var ?OsDistribution $os */
		$os = $this->getRessource(OsDistribution::class, $operatingSystemId);
		if ($os == null) {
			$this->addFlash('negative', "Système d'exploitation inexistant");

			return $this->redirectToRoute('panel_home');
		}

		$vm->setDistrib($os);
		$this->em->flush();

		$vmConnector->install($vm);

		$this->addFlash('info', 'Lancement de la création de la machine');

		return $this->redirectToRoute('panel_vm_show', ['id' => $vm->getId()]);
	}

	#[Route('/{id}/show', name: 'show')]
	#[Override] public function show(int $id, Request $request): Response {
		$vm = $this->getVm($id);

		if ($vm == null) {
			$this->addFlash('danger', "Cette ressource n'existe pas");

			return $this->redirectToRoute('panel_home');
		}

		/** @var Customer $customer */
		$customer = $this->getUser();
		if ($vm->getCustomer() !== $customer) {
			$this->addFlash('danger', "Vous n'êtes pas autorisés à afficher cette ressource");

			return $this->redirectToRoute('panel_home');
		}

		return $this->render('pages/panel/vm/show.html.twig');
	}

	#[Route('/{id}/start', name: 'start')]
	public function start(): Response {
		//

		return new Response();
	}

	#[Route('/{id}/stop', name: 'stop')]
	public function stop(): Response {
		//

		return new Response();
	}

	public function config(int $id, Request $request): Response {
		//

		return new Response();
	}

}
