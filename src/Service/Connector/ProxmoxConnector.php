<?php
namespace App\Service\Connector;

use App\Entity\Server;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ProxmoxConnector {

	public function __construct(private HttpClientInterface $client) {}

	public function getClient(Server $server): HttpClientInterface {
		return $this->client->withOptions([
			'headers' => [
				'X-Api-Token' => $server->getApiKey()
			],
			'base_uri' => $server->getApiUrl()
		]);
	}

}
