<?php
namespace App\Entity;

use App\Entity\Services\SellableService;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Infra\ServiceIp;
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

	#[ORM\OneToMany(mappedBy: 'related_service', targetEntity: ServiceIp::class)]
	private Collection $ips;

	#[ORM\ManyToOne(inversedBy: 'services')]
	private ?Order $related_order = null;

	#[ORM\ManyToOne(inversedBy: 'services')]
	#[ORM\JoinColumn(nullable: false)]
	private ?Customer $customer = null;

	public function __construct() {
		$this->ips = new ArrayCollection();
	}

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

	/**
	 * @return Collection<int, ServiceIp>
	 */
	public function getIps(): Collection {
		return $this->ips;
	}

	public function addIp(ServiceIp $ip): self {
		if (!$this->ips->contains($ip)) {
			$this->ips->add($ip);
			$ip->setRelatedService($this);
		}

		return $this;
	}

	public function removeIp(ServiceIp $ip): self {
		if ($this->ips->removeElement($ip)) {
			// set the owning side to null (unless already changed)
			if ($ip->getRelatedService() === $this) {
				$ip->setRelatedService(null);
			}
		}

		return $this;
	}

	public function getRelatedOrder(): ?Order {
		return $this->related_order;
	}

	public function setRelatedOrder(?Order $related_order): self {
		$this->related_order = $related_order;

		return $this;
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
