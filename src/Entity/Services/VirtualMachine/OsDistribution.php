<?php

namespace App\Entity\Services\VirtualMachine;

use App\Repository\Services\VirtualMachine\OsDistributionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OsDistributionRepository::class)]
class OsDistribution {

	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column]
	private ?int $id = null;

	#[ORM\Column(length: 255)]
	private ?string $iso = null;

	#[ORM\Column]
	private ?bool $is_enabled = null;

	#[ORM\Column(length: 255)]
	private ?string $version = null;

	#[ORM\Column(length: 255)]
	private ?string $name = null;

	public function getId(): ?int {
		return $this->id;
	}

	public function getIso(): ?string {
		return $this->iso;
	}

	public function setIso(string $iso): self {
		$this->iso = $iso;

		return $this;
	}

	public function isIsEnabled(): ?bool {
		return $this->is_enabled;
	}

	public function setIsEnabled(bool $is_enabled): self {
		$this->is_enabled = $is_enabled;

		return $this;
	}

	public function getVersion(): ?string {
		return $this->version;
	}

	public function setVersion(string $version): self {
		$this->version = $version;

		return $this;
	}

	public function getName(): ?string {
		return $this->name;
	}

	public function setName(string $name): self {
		$this->name = $name;

		return $this;
	}

}
