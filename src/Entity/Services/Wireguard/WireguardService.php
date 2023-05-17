<?php

namespace App\Entity\Services\Wireguard;

use App\Entity\AbstractService;
use App\Repository\Services\Wireguard\WireguardServiceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WireguardServiceRepository::class)]
class WireguardService extends AbstractService {

	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column]
	private ?int $id = null;

	#[ORM\Column(length: 255, nullable: true)]
	private ?string $ipv4 = null;

	#[ORM\Column(length: 255, nullable: true)]
	private ?string $ipv6 = null;

	public function getServiceName(): string {
		return "Tunnel wireguard";
	}

	public function getId(): ?int {
		return $this->id;
	}

	public function getIpv4(): ?string {
		return $this->ipv4;
	}

	public function setIpv4(?string $ipv4): self {
		$this->ipv4 = $ipv4;

		return $this;
	}

	public function getIpv6(): ?string {
		return $this->ipv6;
	}

	public function setIpv6(?string $ipv6): self {
		$this->ipv6 = $ipv6;

		return $this;
	}

}
