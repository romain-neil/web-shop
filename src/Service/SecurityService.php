<?php

namespace App\Service;

use App\Entity\Customer;
use App\Entity\Logs\AuditLog;
use App\Entity\User;
use App\Enum\AuditLogAction;
use Doctrine\ORM\EntityManagerInterface;

final readonly class SecurityService {
	
	public function __construct(
		private EntityManagerInterface $entityManager
	) {
	}
	
	/**
	 * @param Customer $user
	 * @return void
	 */
	public function setAccountToCompany(Customer $user): void {
		if ($user->getIsCompany()) {
			return; //Already a company
		}
		
		$customer = $this->entityManager->getRepository(Customer::class)->findOneBy(['id' => $user->getId()]);
		if (!$customer) {
			return; // Customer not found ?
		}
		
		$customer->setIsCompany(true);
		$this->entityManager->flush();
		
		$this->createAuditLog($user, AuditLogAction::ACCOUNT_TYPE_CHANGE_REQUESTED, 'is_company', 'false', 'true');
	}
	
	/**
	 * Create an Audit log entry with provided parameters
	 * @param User $user
	 * @param AuditLogAction $action
	 * @param string|null $field
	 * @param string|null $oldValue
	 * @param string|null $newValue
	 * @return void
	 */
	public function createAuditLog(User $user, AuditLogAction $action, ?string $field = null, ?string $oldValue = null, ?string $newValue = null): void {
		$log = new AuditLog();
		$log->setAuthor($user->getId());
		$log->setAction($action->name);
		$log->setDateCreated(new \DateTime());
		
		if ($field !== null) {
			$log->setField($field);
		}
		
		if ($oldValue !== null) {
			$log->setOldValue($oldValue);
		}
		
		if ($newValue !== null) {
			$log->setNewValue($newValue);
		}
		
		$this->entityManager->persist($log);
		$this->entityManager->flush();
	}
	
}