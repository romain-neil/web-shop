<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ServerConfigRepository;

#[ORM\Entity(repositoryClass: ServerConfigRepository::class)]
#[ORM\Table(name: 'shop.server_config')]
class ServerConfig implements \Stringable {

	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column]
	private ?int $id = null;

	#[ORM\Column]
	private ?int $max_cpu = null;

	#[ORM\Column]
	private ?int $max_disk = null;

	#[ORM\Column]
	private ?int $max_memory = null;

	public function getId(): ?int {
		return $this->id;
	}

	public function getMaxCpu(): ?int {
		return $this->max_cpu;
	}

	public function setMaxCpu(int $max_cpu): self {
		$this->max_cpu = $max_cpu;

		return $this;
	}

	public function getMaxDisk(): ?int {
		return $this->max_disk;
	}

	public function setMaxDisk(int $max_disk): self {
		$this->max_disk = $max_disk;

		return $this;
	}

	public function getMaxMemory(): ?int {
		return $this->max_memory;
	}

	public function setMaxMemory(int $max_memory): self {
		$this->max_memory = $max_memory;

		return $this;
	}

	public function __toString(): string {
		return $this->id;
	}

}
