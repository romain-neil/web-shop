<?php

namespace App\Entity;

use App\Repository\ServerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ServerRepository::class)]
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

	public function __construct() {
		$this->services = new ArrayCollection();
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

}
