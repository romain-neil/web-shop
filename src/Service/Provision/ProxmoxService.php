<?php

namespace App\Service\Provision;

use App\Entity\Server;
use App\Entity\Services\VirtualMachine\OsDistribution;
use App\Entity\Services\VirtualMachine\VmService;
use App\Service\AbstractHTTPService;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class ProxmoxService extends AbstractHTTPService implements AbstractProvisionerService {

	private const string ISO_DIR = 'iso_stor';

	/**
	 * @param Server $server Server with PVE
	 * @param VmService $vm Virtual Machine to create
	 * @return void
	 */
	public function provisionVM(Server $server, VmService $vm): void {
		//set base client url
		$this->createClient($server);

		$plan = $vm->getPlan();
	}

	/**
	 * @throws TransportExceptionInterface
	 */
	public function startVM(Server $server, VmService $vm): void {
		$this->createClient($server);

		$req = $this->client->request('post', 'nodes/' . $server->getNodeId() . '/qemu/' . $vm->getVmId() . '/status/start');

		if ($req->getStatusCode() !== 200) {
			throw new \LogicException('Unable to start vm ' . $vm->getVmId() . ' on node ' . $server->getNodeId());
		}
	}

	/**
	 * @throws TransportExceptionInterface
	 */
	public function stopVM(Server $server, VmService $vm): void {
		$this->createClient($server);

		$req = $this->client->request('post', 'nodes/' . $server->getNodeId() . '/qemu/' . $vm->getVmId() . '/status/shutdown');

		if ($req->getStatusCode() !== 200) {
			throw new \LogicException('Unable to shutdown vm ' . $vm->getVmId() . ' on node ' . $server->getNodeId());
		}
	}

	/**
	 * @throws TransportExceptionInterface
	 */
	public function restartVM(Server $server, VmService $vm): void {
		$this->createClient($server);

		$req = $this->client->request('post', 'nodes/' . $server->getNodeId() . '/qemu/' . $vm->getVmId() . '/status/reboot');

		if ($req->getStatusCode() !== 200) {
			throw new \LogicException('Cannot reboot vm');
		}
	}

	/**
	 * @param Server $server
	 * @param VmService $vm
	 * @return array
	 * @throws TransportExceptionInterface
	 * @throws ClientExceptionInterface
	 * @throws RedirectionExceptionInterface
	 * @throws ServerExceptionInterface
	 */
	public function getVNCUrl(Server $server, VmService $vm): array {
		$this->createClient($server);

		$vncTicket = $this->client->request('post', 'nodes/' . $server->getNodeId() . '/qemu/' . $vm->getVmId() . '/vncproxy');

		if ($vncTicket->getStatusCode() !== 200) {
			throw new \LogicException('Unable to obtain ticket for vm ' . $vm->getVmId() . ' on node ' . $server->getNodeId());
		}

		$ticket = json_decode($vncTicket->getContent(), true)['data'];

		$wsVncUrl = $this->client->request('get', 'nodes/' . $server->getNodeId() . '/qemu/' . $vm->getVmId() . '/vncwebsocket', [
			'query' => ['port' => $ticket['port'], 'vncticket' => $ticket['ticket']]
		]);

		if ($wsVncUrl->getStatusCode() !== 200) {
			throw new \LogicException('Unable to create vm vnc for wm ' . $vm->getVmId() . ' on node ' . $server->getNodeId());
		}

		return []; //TODO
	}

	/**
	 * @throws TransportExceptionInterface
	 */
	public function downloadIso(OsDistribution $os): void {
		$servers = $this->em->getRepository(Server::class)->findAll();

		foreach ($servers as $server) {
			$url = $os->getIso();

			$filename = $os->getIsoFilename();

			$data = [
				'content' => 'iso',
				'url' => $url,
				'filename' => $filename
			];

			$client = $this->getClient($server);
			$req = $client->request('post', 'nodes/' . $server->getNodeId() . '/storage/' . self::ISO_DIR . '/download-url', [
				'form_params' => $data
			]);

			if ($req->getStatusCode() !== 200) {
				throw new \LogicException('Unable to download iso ' . $os->__toString() . ' on node ' . $server->getName());
			}
		}
	}

}
