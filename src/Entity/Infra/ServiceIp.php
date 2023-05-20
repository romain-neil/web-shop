<?php

namespace App\Entity\Infra;

use App\Entity\AbstractService;
use App\Repository\Infra\ServiceIpRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use PhpIP\IP;

#[ORM\Entity(repositoryClass: ServiceIpRepository::class)]
class ServiceIp implements \Stringable {

	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column]
	private ?int $id = null;

	#[ORM\Column(length: 255)]
	private ?string $ip = null;

	#[ORM\Column(type: Types::DATETIME_MUTABLE)]
	private ?\DateTimeInterface $date_start_usage = null;

	#[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
	private ?\DateTimeInterface $date_end_usage = null;

	#[ORM\ManyToOne(inversedBy: 'ips')]
	private ?AbstractService $related_service = null;

	public function getId(): ?int {
		return $this->id;
	}

	public function getIp(): ?string {
		return $this->ip;
	}

	public function setIp(string $ip): self {
		$this->ip = $ip;

		return $this;
	}

	public function getDateStartUsage(): ?\DateTimeInterface {
		return $this->date_start_usage;
	}

	public function setDateStartUsage(\DateTimeInterface $date_start_usage): self {
		$this->date_start_usage = $date_start_usage;

		return $this;
	}

	public function getDateEndUsage(): ?\DateTimeInterface {
		return $this->date_end_usage;
	}

	public function setDateEndUsage(?\DateTimeInterface $date_end_usage): self {
		$this->date_end_usage = $date_end_usage;

		return $this;
	}

	public function getRelatedService(): ?AbstractService {
		return $this->related_service;
	}

	public function setRelatedService(?AbstractService $related_service): self {
		$this->related_service = $related_service;

		return $this;
	}

	public function __toString(): string {
		$ip = IP::create($this->ip);

		return $ip->humanReadable();
	}
}
