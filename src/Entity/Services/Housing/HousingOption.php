<?php
namespace App\Entity\Services\Housing;

use App\Repository\Services\Housing\HousingOptionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HousingOptionRepository::class)]
class HousingOption {

	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column]
	private ?int $id = null;

	#[ORM\Column(length: 255, nullable: true)]
	private ?string $name = null;

	#[ORM\Column(length: 255)]
	private ?string $type = null;

	#[ORM\Column]
	private ?int $quantity = null;

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

}
