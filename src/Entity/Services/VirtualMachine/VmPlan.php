<?php

namespace App\Entity\Services\VirtualMachine;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Services\AbstractServicePlan;
use App\Repository\Services\VirtualMachine\VmPlanRepository;

#[ORM\Entity(repositoryClass: VmPlanRepository::class)]
#[ORM\Table(name: 'shop.vm_plan')]
class VmPlan extends AbstractServicePlan {

	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column]
	protected ?int $id = null;

	#[ORM\Column]
	private ?int $storage = null;

	#[ORM\Column]
	private ?int $proc = null;

	#[ORM\Column]
	private ?int $network = null;

	#[ORM\Column]
	private ?int $memory = null;

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

//    public function __toString(): string {
//        return "";
//    }

}
