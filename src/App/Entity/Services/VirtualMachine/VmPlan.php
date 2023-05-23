<?php

namespace App\Entity\Services\VirtualMachine;

use App\Repository\Services\VirtualMachine\VmPlanRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VmPlanRepository::class)]
class VmPlan {

	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column]
	private ?int $id = null;

	#[ORM\Column]
	private ?int $storage = null;

	#[ORM\Column]
	private ?int $proc = null;

	#[ORM\Column]
	private ?int $network = null;

	#[ORM\Column]
	private ?int $memory = null;

	#[ORM\Column]
	private ?int $price = null;

	#[ORM\Column]
	private ?string $commercial_name = null;

	public function getId(): ?int {
		return $this->id;
	}

	public function getStorage(): ?int {
		return $this->storage;
	}

	public function setStorage(int $storage): self {
		$this->storage = $storage;

		return $this;
	}

	public function getProc(): ?int {
		return $this->proc;
	}

	public function setProc(int $proc): self {
		$this->proc = $proc;

		return $this;
	}

	public function getNetwork(): ?int {
		return $this->network;
	}

	public function setNetwork(int $network): self {
		$this->network = $network;

		return $this;
	}

	public function getMemory(): ?int {
		return $this->memory;
	}

	public function setMemory(int $memory): self {
		$this->memory = $memory;

		return $this;
	}

	public function getPrice(): ?int {
		return $this->price;
	}

	public function setPrice(int $price): self {
		$this->price = $price;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getCommercialName(): ?string {
		return $this->commercial_name;
	}

	/**
	 * @param string|null $commercial_name
	 */
	public function setCommercialName(?string $commercial_name): void {
		$this->commercial_name = $commercial_name;
	}

}
