<?php

namespace App\Entity\Services\VirtualMachine;

use App\Repository\Services\VirtualMachine\VmBackupRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VmBackupRepository::class)]
class VmBackup {

	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column]
	private ?int $id = null;

	#[ORM\Column]
	private ?int $size = null;

	#[ORM\Column(type: Types::DATETIME_MUTABLE)]
	private ?\DateTimeInterface $date_created = null;

	#[ORM\ManyToOne(inversedBy: 'backups')]
	#[ORM\JoinColumn(nullable: false)]
	private ?VmService $vm = null;

	public function getId(): ?int {
		return $this->id;
	}

	public function getSize(): ?int {
		return $this->size;
	}

	public function setSize(int $size): self {
		$this->size = $size;

		return $this;
	}

	public function getDateCreated(): ?\DateTimeInterface {
		return $this->date_created;
	}

	public function setDateCreated(\DateTimeInterface $date_created): self {
		$this->date_created = $date_created;

		return $this;
	}

	public function getVm(): ?VmService {
		return $this->vm;
	}

	public function setVm(?VmService $vm): self {
		$this->vm = $vm;

		return $this;
	}

}
