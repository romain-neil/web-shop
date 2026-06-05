<?php
namespace App\Entity\Services\Wireguard;

use App\Entity\Services\AbstractServicePlan;
use App\Repository\Services\Wireguard\WgPlanRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WgPlanRepository::class)]
#[ORM\Table(name: 'services.wg_plan')]
class WgPlan extends AbstractServicePlan {

}
