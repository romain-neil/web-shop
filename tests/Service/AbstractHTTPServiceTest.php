<?php

namespace App\Tests\Service;

use App\Entity\Server;
use App\Service\AbstractHTTPService;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * Tests for AbstractHTTPService
 */
final class AbstractHTTPServiceTest extends TestCase {
	
	/**
	 * A small concrete subclass we can use to expose protected members
	 */
	private function makeService(EntityManagerInterface $em): TestableAbstractHTTPService {
		return new TestableAbstractHTTPService($em);
	}
	
	public function testConstructorStoresEntityManager(): void {
		$em = $this->createMock(EntityManagerInterface::class);
		$service = $this->makeService($em);
		
		$this->assertSame($em, $service->getExposedEntityManager());
	}
	
	public function testGetClientReturnsHttpClientInterface(): void {
		$em = $this->createMock(EntityManagerInterface::class);
		$service = $this->makeService($em);
		
		$server = new Server();
		$server->setApiUrl('https://example.test/api/');
		
		$client = $service->publicGetClient($server);
		
		$this->assertInstanceOf(HttpClientInterface::class, $client);
	}
	
	public function testGetClientSetsInternalClientProperty(): void {
		$em = $this->createMock(EntityManagerInterface::class);
		$service = $this->makeService($em);
		
		$server = new Server();
		$server->setApiUrl('https://example.test/');
		
		$this->assertNull($service->getExposedClient(), 'Client should be null before first access.');
		
		$client = $service->publicGetClient($server);
		
		$this->assertSame($client, $service->getExposedClient(), 'Internal client should match the returned client instance.');
	}
	
}

/**
 * Concrete test helper extending the abstract HTTP service to expose protected methods/props
 */
class TestableAbstractHTTPService extends AbstractHTTPService {
	
	public function getExposedEntityManager(): EntityManagerInterface {
		return $this->em;
	}
	
	public function getExposedClient(): ?HttpClientInterface {
		return $this->client ?? null;
	}
	
	public function publicGetClient(Server $server): HttpClientInterface {
		// Call the protected method from the base class
		return $this->getClient($server);
	}
	
}