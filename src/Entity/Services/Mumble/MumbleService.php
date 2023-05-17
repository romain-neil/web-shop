<?php

namespace App\Entity\Services\Mumble;

use App\Entity\AbstractService;
use App\Repository\Services\Mumble\MumbleServiceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MumbleServiceRepository::class)]
class MumbleService extends AbstractService {

	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column]
	private ?int $id = null;

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

}
