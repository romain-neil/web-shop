<?php
namespace App\Entity\Services\Mumble;

use App\Entity\Services\AbstractServicePlan;
use App\Repository\Services\Mumble\MumblePlanRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MumblePlanRepository::class)]
#[ORM\Table(schema: 'shop')]
class MumblePlan extends AbstractServicePlan {

	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column]
	protected ?int $id = null;

	#[ORM\Column]
	private ?int $slots = null;

	public function getId(): ?int {
		return $this->id;
	}

	public function getSlots(): ?int {
		return $this->slots;
	}

	public function setSlots(int $slots): static {
		$this->slots = $slots;

		return $this;
	}

}
