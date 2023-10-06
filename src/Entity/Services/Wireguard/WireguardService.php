<?php
namespace App\Entity\Services\Wireguard;

use App\Entity\Services\AbstractServicePlan;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\AbstractService;
use App\Repository\Services\Wireguard\WireguardServiceRepository;

#[ORM\Entity(repositoryClass: WireguardServiceRepository::class)]
#[ORM\Table(name: 'shop.wg_service')]
class WireguardService extends AbstractService implements \Stringable {

	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column]
	protected ?int $id = null;

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
	
	public function getPlan(): ?AbstractServicePlan {
		// TODO: Implement getPlan() method.
		return null;
	}
	
	public function setPlan(?AbstractServicePlan $plan) {
		// TODO: Implement setPlan() method.
	}
	
	public function __toString(): string {
		return 'wg';
	}
	
}
