<?php
namespace App\Entity\Services\Mumble;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\AbstractService;
use App\Repository\Services\Mumble\MumbleServiceRepository;

#[ORM\Entity(repositoryClass: MumbleServiceRepository::class)]
#[ORM\Table(name: 'services.mumble_service')]
class MumbleService extends AbstractService {

	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column]
	protected ?int $id = null;

	#[ORM\Column]
	private ?int $channelCounts = null;

	public function getServiceName(): string {
		return "Serveur mumble";
	}

	public function getId(): ?int {
		return $this->id;
	}

	public function getChannelCounts(): ?int {
		return $this->channelCounts;
	}

	public function setChannelCounts(int $channelCounts): self {
		$this->channelCounts = $channelCounts;

		return $this;
	}

	public function __toString(): string {
		return 'mumble';
	}

}
