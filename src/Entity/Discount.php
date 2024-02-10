<?php
namespace App\Entity;

use App\Repository\DiscountRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DiscountRepository::class)]
#[ORM\Table(name: 'shop.discount')]
class Discount {

	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column]
	private ?int $id = null;

	#[ORM\Column]
	private ?int $amount = null;

	#[ORM\Column(nullable: true)]
	private ?int $minimum_order_amount = null;

	#[ORM\Column(nullable: true)]
	private ?int $maximal_total_usage = null;

	#[ORM\Column(type: Types::TEXT)]
	private ?string $code = null;

	#[ORM\OneToMany(mappedBy: 'code', targetEntity: DiscountCodeUsage::class)]
	private Collection $codeUsages;

	/**
	 * @var bool|null Allow multiple use in the same Order ?
	 */
	#[ORM\Column]
	private ?bool $allow_multiple_use = null;

	#[ORM\Column]
	private ?bool $is_percent = null;

	public function __construct() {
		$this->codeUsages = new ArrayCollection();
	}

	public function getId(): ?int {
		return $this->id;
	}

	public function getAmount(): ?int {
		return $this->amount;
	}

	public function setAmount(int $amount): static {
		$this->amount = $amount;

		return $this;
	}

	public function getMinimumOrderAmount(): ?int {
		return $this->minimum_order_amount;
	}

	public function setMinimumOrderAmount(?int $minimum_order_amount): static {
		$this->minimum_order_amount = $minimum_order_amount;

		return $this;
	}

	public function getMaximalTotalUsage(): ?int {
		return $this->maximal_total_usage;
	}

	public function setMaximalTotalUsage(?int $maximal_total_usage): static {
		$this->maximal_total_usage = $maximal_total_usage;

		return $this;
	}

	public function getCode(): ?string {
		return $this->code;
	}

	public function setCode(string $code): static {
		$this->code = $code;

		return $this;
	}

	/**
	 * @return Collection<int, DiscountCodeUsage>
	 */
	public function getCodeUsages(): Collection {
		return $this->codeUsages;
	}

	public function addCodeUsage(DiscountCodeUsage $codeUsage): static {
		if (!$this->codeUsages->contains($codeUsage)) {
			$this->codeUsages->add($codeUsage);
			$codeUsage->setCode($this);
		}

		return $this;
	}

	public function removeCodeUsage(DiscountCodeUsage $codeUsage): static {
		if ($this->codeUsages->removeElement($codeUsage)) {
			// set the owning side to null (unless already changed)
			if ($codeUsage->getCode() === $this) {
				$codeUsage->setCode(null);
			}
		}

		return $this;
	}

	public function isAllowMultipleUse(): ?bool {
		return $this->allow_multiple_use;
	}

	public function setAllowMultipleUse(bool $allow_multiple_use): static {
		$this->allow_multiple_use = $allow_multiple_use;

		return $this;
	}

	public function isIsPercent(): ?bool {
		return $this->is_percent;
	}

	public function setIsPercent(bool $is_percent): static {
		$this->is_percent = $is_percent;

		return $this;
	}

}
