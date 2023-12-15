<?php

namespace App\Entity\Infra;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use PhpIP\IP;
use App\Entity\AbstractService;
use App\Entity\Server;
use App\Repository\Infra\ServiceIpRepository;

#[ORM\Entity(repositoryClass: ServiceIpRepository::class)]
#[ORM\Table(name: 'shop.service_ip')]
class ServiceIp implements \Stringable {

	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column]
	private ?int $id = null;

	#[ORM\Column(length: 255)]
	private ?string $ip = null;

	#[ORM\Column(type: Types::DATETIME_MUTABLE)]
	private ?\DateTimeInterface $date_start_usage = null;

	#[ORM\ManyToOne(inversedBy: 'ips')]
	private ?AbstractService $related_service = null;

	#[ORM\ManyToOne(inversedBy: 'ip_resources')]
	private ?Server $server = null;

	/**
	 * Is the ip a block ?
	 * @var bool|null
	 */
	#[ORM\Column]
	private ?bool $is_block = null;

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

	public function getRelatedService(): ?AbstractService {
		return $this->related_service;
	}

	public function setRelatedService(?AbstractService $related_service): self {
		$this->related_service = $related_service;

		return $this;
	}

	public function getServer(): ?Server {
		return $this->server;
	}

	public function setServer(?Server $server): self {
		$this->server = $server;

		return $this;
	}

	public function isBlock(): ?bool {
		return $this->is_block;
	}

	public function setIsBlock(bool $is_block): self {
		$this->is_block = $is_block;

		return $this;
	}

	public function __toString(): string {
		$ip = IP::create($this->ip);

		return $ip->humanReadable();
	}

}
