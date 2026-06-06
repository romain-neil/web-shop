<?php

namespace App\Service\Provision;

use App\Entity\AbstractService;

/**
 * Interface for abstract provisioner service
 */
interface IAbstractProvisioner {
	
	/**
	 * The function checks if the service is alive on the server
	 * @return bool true if the service is alive, false otherwise
	 */
	public function checkIsAlive(): bool;
	
	/**
	 * This function checks if the service is existing on the server
	 * @param AbstractService $service
	 * @return bool
	 */
	public function checkServiceExists(AbstractService $service): bool;
	
	/**
	 * This function should create the service on the server
	 * @param AbstractService $service
	 * @return void
	 */
	public function createService(AbstractService $service): void;
	
}