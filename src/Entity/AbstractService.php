<?php
namespace App\Entity;

use App\Repository\AbstractServiceRepository;
use Stringable;

#[ORM\Entity(repositoryClass: AbstractServiceRepository::class)]
#[ORM\Table(name: 'shop.abstract_service')]
#[ORM\InheritanceType('JOINED')]
#[ORM\DiscriminatorColumn(name: 'discr', type: 'string')]
#[ORM\DiscriminatorMap([
	'abstractService' => 'AbstractService',
	'housing' => 'App\Entity\Services\Housing\HousingService',
	'mumble' => 'App\Entity\Services\Mumble\MumbleService',
	'vm' => 'App\Entity\Services\VirtualMachine\VmService',
	'wireguard' => 'App\Entity\Services\Wireguard\WireguardService',
	'vm' => 'App\Entity\Services\VirtualMachine\VmService'
])]
#[ORM\Table(name: 'shop.abstract_service')]
abstract class AbstractService implements Stringable, SellableService {

	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column]
	protected ?int $id = null;

	public function getId(): ?int {
		return $this->id;
	}

	#[ORM\ManyToOne(inversedBy: 'services')]
	private Server $server;

	#[ORM\Column]
	private string $internal_service_name;

	#[ORM\ManyToOne(inversedBy: 'services')]
	#[ORM\JoinColumn(nullable: false)]
	private ?Customer $customer = null;
	abstract public function getServiceName(): string;

	public function getServer(): Server {
		return $this->server;
	}

	public function setServer(?Server $server): self {
		$this->server = $server;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getInternalServiceName(): string {
		return $this->internal_service_name;
	}

	/**
	 * @param string $internal_service_name
	 */
	public function setInternalServiceName(string $internal_service_name): void {
		$this->internal_service_name = $internal_service_name;
	}

	public function getPropertiesList(): array {
		return get_object_vars($this);
	}

	public function getCustomer(): ?Customer {
		return $this->customer;
	}

	public function setCustomer(?Customer $customer): self {
		$this->customer = $customer;

		return $this;
	}

	public function getPrettyUrl(): string {
		return sprintf('%s.infra.carow.fr', $this->__toString());
	}

}
