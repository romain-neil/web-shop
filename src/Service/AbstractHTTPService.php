<?php

namespace App\Service;

use App\Entity\Server;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * This class is in charge of creating an http client, to be used within Server API url
 */
class AbstractHTTPService {
	
	protected HttpClientInterface $client;
	
	protected EntityManagerInterface $em;
	
	/**
	 * Initialize required variables
	 * @param EntityManagerInterface $manager the entity manager
	 */
	public function __construct(EntityManagerInterface $manager) {
		$this->em = $manager;
	}
	
	/**
	 * Create the http client for the server
	 * @param Server $server
	 * @return void
	 */
	protected function createClient(Server $server): void {
		$this->client = HttpClient::create([
			'base_uri' => $server->getApiUrl(),
		]);
	}
	
	/**
	 * Return the http client for the server
	 * @param Server $server
	 * @return HttpClientInterface
	 */
	protected function getClient(Server $server): HttpClientInterface {
		$this->createClient($server);
		return $this->client;
	}
	
}