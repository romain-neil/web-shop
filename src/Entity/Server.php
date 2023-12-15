<?php

namespace App\Entity;

use App\Entity\Infra\ServiceIp;
use App\Repository\ServerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ServerRepository::class)]
#[ORM\Table(name: 'shop.server')]
class Server implements \Stringable {

	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column]
	private int $id;

	#[ORM\ManyToOne(inversedBy: 'servers')]
	#[ORM\JoinColumn(nullable: false)]
	private ?ServiceRegion $region = null;

	#[ORM\OneToMany(mappedBy: 'server', targetEntity: AbstractService::class)]
	private Collection $services;

	#[ORM\Column(length: 255)]
	private string $name;

	#[ORM\Column(nullable: true)]
	private ?string $node_id = null;

	#[ORM\Column(type: Types::GUID, nullable: true)]
	private ?string $uuid = null;

	#[ORM\OneToMany(mappedBy: 'server', targetEntity: ServiceIp::class)]
	private Collection $ip_resources;

	public function __construct() {
		$this->services = new ArrayCollection();
		$this->ip_resources = new ArrayCollection();
	}

	public function getId(): ?int {
		return $this->id;
	}

	public function getRegion(): ?ServiceRegion {
		return $this->region;
	}

	public function setRegion(?ServiceRegion $region): self {
		$this->region = $region;

		return $this;
	}

	/**
	 * @return Collection<int, AbstractService>
	 */
	public function getServices(): Collection {
		return $this->services;
	}

	public function addService(AbstractService $service): self {
		if (!$this->services->contains($service)) {
			$this->services->add($service);
			$service->setServer($this);
		}

		return $this;
	}

	public function removeService(AbstractService $service): self {
		if ($this->services->removeElement($service)) {
			// set the owning side to null (unless already changed)
			if ($service->getServer() === $this) {
				$service->setServer(null);
			}
		}

		return $this;
	}

	public function getName(): string {
		return $this->name;
	}

	public function setName(string $name): self {
		$this->name = $name;

		return $this;
	}

	public function getNodeId(): ?string {
		return $this->node_id;
	}

	public function setNodeId(?string $node_id): string {
		$this->node_id = $node_id;

		return $this;
	}

	/**
	 * Return the server' pretty name, composed by his name, his region name following infrastructure' name scheme
	 *
	 * e.g.: mumble-pod-1.eu-west-1.infra.carow.fr
	 *
	 * @return string
	 */
	public function getPrettyName(): string {
		return sprintf("%s.%s.infra.carow.fr", $this->name, $this->region->getName());
	}

	public function __toString(): string {
		return $this->name;
	}

	public function getUuid(): ?string {
		return $this->uuid;
	}

	public function setUuid(string $uuid): self {
		$this->uuid = $uuid;

		return $this;
	}

	/**
	 * @return Collection<int, ServiceIp>
	 */
	public function getIpResources(): Collection {
		return $this->ip_resources;
	}

	public function addIpResource(ServiceIp $ipResource): self {
		if (!$this->ip_resources->contains($ipResource)) {
			$this->ip_resources->add($ipResource);
			$ipResource->setServer($this);
		}

		return $this;
	}

	public function removeIpResource(ServiceIp $ipResource): self {
		if ($this->ip_resources->removeElement($ipResource)) {
			// set the owning side to null (unless already changed)
			if ($ipResource->getServer() === $this) {
				$ipResource->setServer(null);
			}
		}

		return $this;
	}

}
