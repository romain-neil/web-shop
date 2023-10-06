<?php

namespace App\Entity\Services\Wireguard;

use App\Entity\Services\AbstractServicePlan;
use App\Repository\Services\Wireguard\WgPlanRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WgPlanRepository::class)]
#[ORM\Table(name: 'shop.wg_plan')]
class WgPlan extends AbstractServicePlan {

	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column]
	protected ?int $id = null;

	public function getId(): ?int {
		return $this->id;
	}

}
