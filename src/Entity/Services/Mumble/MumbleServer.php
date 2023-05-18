<?php

namespace App\Entity\Services\Mumble;

use App\Repository\Services\Mumble\MumbleServerRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MumbleServerRepository::class)]
class MumbleServer {

	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column(type: 'integer')]
	private int $id;

	#[ORM\Column(type: 'integer')]
	private ?int $channelCount;

	public function getId(): ?int {
		return $this->id;
	}

	public function getChannelCount(): ?int {
		return $this->channelCount;
	}

	public function setChannelCount(int $channelCount): self {
		$this->channelCount = $channelCount;

		return $this;
	}

}
