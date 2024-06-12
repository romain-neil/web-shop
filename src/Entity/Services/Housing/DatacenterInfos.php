<?php
namespace App\Entity\Services\Housing;

use App\Repository\Services\Housing\DatacenterInfosRepository;
use CrEOF\Spatial\PHP\Types\Geometry\Point;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DatacenterInfosRepository::class)]
#[ORM\Table(name: 'services.datacenter_infos')]
class DatacenterInfos {

	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column]
	protected ?int $id = null;

	#[ORM\Column(name: 'coordinates', type: 'point', nullable: false)]
	private ?Point $coordinates = null;

	#[ORM\Column]
	private ?string $name = null;

	#[ORM\Column]
	private ?string $dc_tier = null;

	/**
	 * @var bool|null Does the datacenter have the uptime institute certification, or his tier are equivalent
	 */
	#[ORM\Column]
	private ?bool $has_certificate = null;

	#[ORM\Column]
	private ?string $dc_address = null;

	#[ORM\OneToMany(mappedBy: 'datacenter', targetEntity: HousingService::class)]
	private Collection $housingServices;

	public function __construct() {
		$this->housingServices = new ArrayCollection();
	}

	public function getId(): ?int {
		return $this->id;
	}

	public function setId(?int $id): void {
		$this->id = $id;
	}

	/**
	 * Get the coordinates property.
	 *
	 * @return \CrEOF\Spatial\PHP\Types\Geometry\Point|null
	 */
	public function getCoordinates(): ?Point {
		return $this->coordinates;
	}

	/**
	 * Set the coordinates property.
	 *
	 * @param Point $coordinates
	 * @return self
	 */
	public function setCoordinates(Point $coordinates): self {
		$this->coordinates = $coordinates;

		return $this;
	}

	//https://ourcodeworld.com/articles/read/1588/how-to-work-with-point-data-type-in-doctrine-2-and-symfony-5
	public function setPoint(string $longitude, string $latitude): self {
		$this->coordinates = new Point($longitude, $latitude);

		return $this;
	}

	public function getPoint(): string {
		return $this->coordinates->getX() . " " . $this->coordinates->getY();
	}

	public function getName(): ?string {
		return $this->name;
	}

	public function setName(?string $dc_name): void {
		$this->name = $dc_name;
	}

	public function getDcTier(): ?string {
		return $this->dc_tier;
	}

	public function setDcTier(?string $dc_tier): void {
		$this->dc_tier = $dc_tier;
	}

	public function getHasCertificate(): ?bool {
		return $this->has_certificate;
	}

	public function setHasCertificate(?bool $has_certificate): void {
		$this->has_certificate = $has_certificate;
	}

	public function getDcAddress(): ?string {
		return $this->dc_address;
	}

	public function setDcAddress(?string $dc_address): void {
		$this->dc_address = $dc_address;
	}

	/**
	 * @return Collection<int, HousingService>
	 */
	public function getHousingServices(): Collection {
		return $this->housingServices;
	}

	public function addHousingService(HousingService $housingService): static {
		if (!$this->housingServices->contains($housingService)) {
			$this->housingServices->add($housingService);
			$housingService->setDatacenter($this);
		}

		return $this;
	}

	public function removeHousingService(HousingService $housingService): static {
		if ($this->housingServices->removeElement($housingService)) {
			// set the owning side to null (unless already changed)
			if ($housingService->getDatacenter() === $this) {
				$housingService->setDatacenter(null);
			}
		}

		return $this;
	}

}
