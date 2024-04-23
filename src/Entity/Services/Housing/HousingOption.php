<?php
namespace App\Entity\Services\Housing;

use App\Repository\Services\Housing\HousingOptionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HousingOptionRepository::class)]
#[ORM\Table(name: 'services.housing_option')]
class HousingOption {

	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column]
	private ?int $id = null;

	/**
	 * @var string|null Nom commercial de l'offre
	 */
	#[ORM\Column(length: 255, nullable: true)]
	private ?string $name = null;

	#[ORM\Column(length: 255)]
	private ?string $type = null;

	#[ORM\Column]
	private ?int $quantity = null;

	/**
	 * @var int|null Only applicable to network options
	 */
	#[ORM\Column(nullable: true)]
	private ?int $base_speed = null;

	/**
	 * @var int|null Only applicable to network options
	 */
	#[ORM\Column(nullable: true)]
	private ?int $max_speed = null;

	/**
	 * @var int|null Option internal code
	 */
	#[ORM\Column(nullable: false)]
	private ?int $code = null;

	public function getId(): ?int {
		return $this->id;
	}

	public function getName(): ?string {
		return $this->name;
	}

	public function setName(?string $name): void {
		$this->name = $name;
	}

	public function getType(): ?string {
		return $this->type;
	}

	public function setType(string $type): static {
		$this->type = $type;

		return $this;
	}

	public function getQuantity(): ?int {
		return $this->quantity;
	}

	public function setQuantity(int $quantity): static {
		$this->quantity = $quantity;

		return $this;
	}

	public function getBaseSpeed(): ?int {
		return $this->base_speed;
	}

	public function setBaseSpeed(?int $base_speed): void {
		$this->base_speed = $base_speed;
	}

	public function getMaxSpeed(): ?int {
		return $this->max_speed;
	}

	public function setMaxSpeed(?int $max_speed): void {
		$this->max_speed = $max_speed;
	}

	public function getCode(): ?int {
		return $this->code;
	}

	public function setCode(?int $code): void {
		$this->code = $code;
	}

}
