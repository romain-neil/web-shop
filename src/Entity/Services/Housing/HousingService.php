<?php
namespace App\Entity\Services\Housing;

use App\Entity\AbstractService;
use App\Repository\Services\Housing\HousingServiceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HousingServiceRepository::class)]
#[ORM\Table(name: 'shop.housing_service')]
class HousingService extends AbstractService {

	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column]
	protected ?int $id = null;

	/**
	 * @var int|null Nombre de U dans le datacenter
	 */
	#[ORM\Column]
	private ?int $space_reserved = null;

	#[ORM\ManyToOne(inversedBy: 'housingServices')]
	#[ORM\JoinColumn(nullable: false)]
	private ?DatacenterInfos $datacenter = null;

	#[ORM\ManyToMany(targetEntity: HousingOption::class)]
	private Collection $options;

	public function __construct() {
		$this->options = new ArrayCollection();
	}

	public function getServiceName(): string {
		return 'Collocation';
	}

	public function __toString(): string {
		return 'housing';
	}

	public function getDatacenter(): ?DatacenterInfos {
		return $this->datacenter;
	}

	public function setDatacenter(?DatacenterInfos $datacenter): static {
		$this->datacenter = $datacenter;

		return $this;
	}

	public function getSpaceReserved(): ?int {
		return $this->space_reserved;
	}

	public function setSpaceReserved(?int $space_reserved): void {
		$this->space_reserved = $space_reserved;
	}

	/**
	 * @return Collection<int, HousingOption>
	 */
	public function getOptions(): Collection {
		return $this->options;
	}

	public function addOption(HousingOption $option): static {
		if (!$this->options->contains($option)) {
			$this->options->add($option);
		}

		return $this;
	}

	public function removeOption(HousingOption $option): static {
		$this->options->removeElement($option);

		return $this;
	}

}
