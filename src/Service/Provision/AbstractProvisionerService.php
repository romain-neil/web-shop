<?php

namespace App\Service\Provision;

use App\Entity\Server;
use App\Entity\Services\VirtualMachine\OsDistribution;
use App\Entity\Services\VirtualMachine\VmService;

interface AbstractProvisionerService {
	
	// Virtual Machine related methods
	
	public function provisionVM(Server $server, VmService $vm): void;
	
	/**
	 * Start the virtual machine
	 * @param Server $server
	 * @param VmService $vm
	 * @return void
	 */
	public function startVM(Server $server, VmService $vm): void;
	
	/**
	 * Stop the virtual machine
	 * @param Server $server
	 * @param VmService $vm
	 * @return void
	 */
	public function stopVM(Server $server, VmService $vm): void;
	
	/**
	 * Restart the virtual machine
	 * @param Server $server
	 * @param VmService $vm
	 * @return void
	 */
	public function restartVM(Server $server, VmService $vm): void;
	
	// Hypervisor management related methods
	
	/**
	 * Download the ISO for the given OS
	 * @param OsDistribution $os
	 * @return void
	 */
	public function downloadIso(OsDistribution $os): void;
	
}