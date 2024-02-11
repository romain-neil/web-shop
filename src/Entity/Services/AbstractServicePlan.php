<?php
namespace App\Entity\Services;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\Services\AbstractServicePlanRepository;

#[ORM\Entity(repositoryClass: AbstractServicePlanRepository::class)]
#[ORM\InheritanceType('JOINED')]
#[ORM\DiscriminatorColumn(name: 'discr', type: 'string')]
#[ORM\DiscriminatorMap([
	'mumble' => 'App\Entity\Services\Mumble\MumblePlan',
    'vm' => 'App\Entity\Services\VirtualMachine\VmPlan',
	'wg' => 'App\Entity\Services\Wireguard\WgPlan'
])]
#[ORM\Table(name: 'shop.abstract_service_plan')]
abstract class AbstractServicePlan {

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected ?int $id = null;
	
	#[ORM\Column]
	private ?string $commercial_name = null;
	
	#[ORM\Column]
	private ?int $price = null;
	
	public function getId(): ?int {
        return $this->id;
    }
	
	/**
	 * @return string
	 */
	public function getCommercialName(): string {
		return $this->commercial_name;
	}
	
	/**
	 * @param string|null $commercial_name
	 */
	public function setCommercialName(?string $commercial_name): void {
		$this->commercial_name = $commercial_name;
	}
	
	public function getPrice(): ?int {
		return $this->price;
	}
	
	public function setPrice(int $price): self {
		$this->price = $price;
		
		return $this;
	}

}
