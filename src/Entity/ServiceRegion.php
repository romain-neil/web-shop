<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ServiceRegionRepository;
use Stringable;

#[ORM\Entity(repositoryClass: ServiceRegionRepository::class)]
#[ORM\Table(name: 'shop.service_region')]
class ServiceRegion implements Stringable {

	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column]
	private int $id;

	#[ORM\Column(length: 255)]
	private string $name;

	#[ORM\OneToMany(mappedBy: 'region', targetEntity: Server::class)]
	private Collection $servers;

	public function __construct() {
		$this->servers = new ArrayCollection();
	}

	public function getId(): ?int {
		return $this->id;
	}

	public function getName(): string {
		return $this->name;
	}

	public function setName(string $name): self {
		$this->name = $name;

		return $this;
	}

	/**
	 * @return Collection<int, Server>
	 */
	public function getServers(): Collection {
		return $this->servers;
	}

	public function addServer(Server $server): self {
		if (!$this->servers->contains($server)) {
			$this->servers->add($server);
			$server->setRegion($this);
		}

		return $this;
	}

	public function removeServer(Server $server): self {
		if ($this->servers->removeElement($server)) {
			// set the owning side to null (unless already changed)
			if ($server->getRegion() === $this) {
				$server->setRegion(null);
			}
		}

		return $this;
	}

	public function __toString(): string {
		return $this->name;
	}

}
