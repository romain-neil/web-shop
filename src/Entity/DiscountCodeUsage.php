<?php
namespace App\Entity;

use App\Repository\DiscountCodeUsageRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DiscountCodeUsageRepository::class)]
#[ORM\Table(name: 'shop.discount_code_usage')]
class DiscountCodeUsage {

	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column]
	private ?int $id = null;

	#[ORM\ManyToOne(inversedBy: 'codeUsages')]
	#[ORM\JoinColumn(nullable: false)]
	private ?Discount $code = null;

	#[ORM\Column(type: Types::DATETIME_MUTABLE)]
	private ?\DateTimeInterface $date_usage = null;

	#[ORM\ManyToOne(inversedBy: 'discountCodeUsages')]
	#[ORM\JoinColumn(nullable: false)]
	private ?Order $related_order = null;

	public function getId(): ?int {
		return $this->id;
	}

	public function getCode(): ?Discount {
		return $this->code;
	}

	public function setCode(?Discount $code): static {
		$this->code = $code;

		return $this;
	}

	public function getDateUsage(): ?\DateTimeInterface {
		return $this->date_usage;
	}

	public function setDateUsage(\DateTimeInterface $date_usage): static {
		$this->date_usage = $date_usage;

		return $this;
	}

	public function getRelatedOrder(): ?Order {
		return $this->related_order;
	}

	public function setRelatedOrder(?Order $related_order): static {
		$this->related_order = $related_order;

		return $this;
	}

}
