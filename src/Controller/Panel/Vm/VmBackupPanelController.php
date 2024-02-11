<?php
namespace App\Controller\Panel\Vm;

use App\Entity\Customer;
use App\Entity\Services\VirtualMachine\VmBackup;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/panel/vm/backup', name: 'panel_vm_backup_')]
class VmBackupPanelController extends VmPanelController {

	private function getBackup(int $id): ?VmBackup {
		return $this->getRessource(VmBackup::class, $id);
	}

	/**
	 * @throws \Exception
	 */
	private function checkBackupAccess(int $id): VmBackup {
		$backup = $this->getBackup($id);

		if ($backup == null) {
			$this->addFlash('error', "Il n'existe pas de backup avec cet identifiant");

			throw new \Exception();
		}

		/** @var Customer $customer */
		$customer = $this->getUser();
		if ($backup->getVm()->getCustomer() !== $customer) {
			$this->addFlash('error', "Vous n'avez pas accès à cette information");

			throw new \Exception();
		}

		return $backup;
	}

	#[Route('/{backup}/restore', name: 'restore')]
	public function restoreBackup(int $backup): Response {
		try {
			$backup = $this->checkBackupAccess($backup);
		} catch (\Exception) {
			return $this->redirectToRoute('panel_home');
		}

		$this->vmConnector->restoreBackup($backup);

		$vmId = $backup->getVm()->getId();

		return $this->redirectToRoute('panel_vm_show', ['id' => $vmId]);
	}

	#[Route('/{backup}/delete', name: 'delete')]
	public function deleteBackup(int $backup): RedirectResponse {
		try {
			$backup = $this->checkBackupAccess($backup);
		} catch (\Exception) {
			return $this->redirectToRoute('panel_home');
		}

		$this->vmConnector->removeBackup($backup);

		$vmId = $backup->getVm()->getId();

		return $this->redirectToRoute('panel_vm_show', ['id' => $vmId]);
	}

}
