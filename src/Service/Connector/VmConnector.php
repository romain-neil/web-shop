<?php
namespace App\Service\Connector;

use App\Entity\Services\VirtualMachine\VmBackup;
use App\Entity\Services\VirtualMachine\VmService;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class VmConnector {

	public function __construct(private readonly ProxmoxConnector $proxmox) {}

	public function install(VmService $vm): void {
		//
	}

	/**
	 * @throws TransportExceptionInterface
	 * @throws \Exception
	 */
	public function createBackup(VmService $vm): void {
		$server = $vm->getServer();

		$req = $this->proxmox->getClient($server)->request('POST', '/api2/json/nodes/' . $server->getNodeId() . '/vzdump', [
			'body' => [
				'all' => 0,
				'mode' => 'suspend',
				'vmid' => $vm->getVmId()
			]
		]);

		if ($req->getStatusCode() !== 200) {
			throw new \Exception();
		}
	}

	public function restoreBackup(VmBackup $backup): void {
		$server = $backup->getVm()->getServer();
	}

	public function removeBackup(VmBackup $backup): void {
		$server = $backup->getVm()->getServer();
	}

	/**
	 * @param VmService $vm
	 * @return void
	 * @throws TransportExceptionInterface
	 * @throws \Exception
	 */
	public function start(VmService $vm): void {
		$server = $vm->getServer();

		$req = $this->proxmox->getClient($server)->request('POST', '/api2/json/nodes/' . $server->getNodeId() . '/qemu/' . $vm->getVmId() . '/status/start');

		if ($req->getStatusCode() !== 200) {
			throw new \Exception();
		}
	}

	/**
	 * @throws TransportExceptionInterface
	 * @throws \Exception
	 */
	public function shutdown(VmService $vm): void {
		$server = $vm->getServer();

		$req = $this->proxmox->getClient($server)->request('POST', '/api2/json/nodes/' . $server->getNodeId() . '/qemu/' . $vm->getVmId() . '/status/shutdown');

		if ($req->getStatusCode() !== 200) {
			throw new \Exception();
		}
	}

	/**
	 * @throws TransportExceptionInterface
	 * @throws \Exception
	 */
	public function stop(VmService $vm): void {
		$server = $vm->getServer();

		$req = $this->proxmox->getClient($server)->request('POST', '/api2/json/nodes/' . $server->getNodeId() . '/qemu/' . $vm->getVmId() . '/status/stop');

		if ($req->getStatusCode() !== 200) {
			throw new \Exception();
		}
	}

}
