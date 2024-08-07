<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\OrderRepository;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: 'shop.`order`')]
class Order {

	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column]
	private ?int $id = null;

	#[ORM\Column(type: Types::DATETIME_MUTABLE)]
	private ?\DateTimeInterface $date_created = null;

	#[ORM\Column]
	private ?bool $paid = null;

	#[ORM\Column]
	private ?bool $in_cart = null;

	#[ORM\OneToMany(mappedBy: 'related_order', targetEntity: AbstractService::class, fetch: 'EAGER')]
	private Collection $services;

	#[ORM\Column]
	private ?bool $isPending = null;

	#[ORM\ManyToOne]
	#[ORM\JoinColumn(nullable: false)]
	private ?Customer $customer = null;

	#[ORM\Column(length: 255, nullable: true)]
	private ?string $contrat_ref = null;

	#[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
	private ?\DateTimeInterface $date_end_valid = null;

	#[ORM\OneToMany(mappedBy: 'related_order', targetEntity: DiscountCodeUsage::class, fetch: 'EAGER', orphanRemoval: true)]
	private Collection $discountCodeUsages;

	public function __construct() {
		$this->services = new ArrayCollection();
		$this->discountCodeUsages = new ArrayCollection();
	}

	public function getId(): ?int {
		return $this->id;
	}

	public function getDateCreated(): ?\DateTimeInterface {
		return $this->date_created;
	}

	public function setDateCreated(\DateTimeInterface $date_created): self {
		$this->date_created = $date_created;

		return $this;
	}

	public function isPaid(): ?bool {
		return $this->paid;
	}

	public function setPaid(bool $paid): self {
		$this->paid = $paid;

		return $this;
	}

	public function isInCart(): ?bool {
		return $this->in_cart;
	}

	public function setInCart(bool $in_cart): self {
		$this->in_cart = $in_cart;

		return $this;
	}

	/**
	 * @return Collection<int, AbstractService>
	 */
	public function getServices(): Collection {
		return $this->services;
	}

	public function addService(AbstractService $service): self {
		if (!$this->services->contains($service)) {
			$this->services->add($service);
			$service->setRelatedOrder($this);
		}

		return $this;
	}

	public function removeService(AbstractService $service): self {
		if ($this->services->removeElement($service)) {
			// set the owning side to null (unless already changed)
			if ($service->getRelatedOrder() === $this) {
				$service->setRelatedOrder(null);
			}
		}

		return $this;
	}

	public function getIsPending(): ?bool {
		return $this->isPending;
	}

	public function setIsPending(?bool $isPending): void {
		$this->isPending = $isPending;
	}

	public function getCustomer(): ?Customer {
		return $this->customer;
	}

	public function setCustomer(?Customer $customer): self {
		$this->customer = $customer;

		return $this;
	}

	public function getTotal(): int {
		$total = 0;

		$services = $this->getServices();
		foreach ($services as $service) {
			$total += $service->getPlan()->getPrice();
		}

		$discounts = $this->getDiscountCodeUsages();
		foreach ($discounts as $discount) {
			$code = $discount->getCode();
			$amount = $code->getAmount() / 100;

			if ($code->isIsPercent()) {
				$total -= ($total * $amount);
			} else {
				$total -= $amount;
			}
		}

		return $total;
	}

	public function getContratRef(): ?string {
		return $this->contrat_ref;
	}

	public function setContratRef(?string $contrat_ref): self {
		$this->contrat_ref = $contrat_ref;

		return $this;
	}

	public function getDateEndValid(): ?\DateTimeInterface {
		return $this->date_end_valid;
	}

	public function setDateEndValid(?\DateTimeInterface $date_end_valid): self {
		$this->date_end_valid = $date_end_valid;

		return $this;
	}

	/**
	 * @return Collection<int, DiscountCodeUsage>
	 */
	public function getDiscountCodeUsages(): Collection {
		return $this->discountCodeUsages;
	}

	public function addDiscountCodeUsage(DiscountCodeUsage $discountCodeUsage): static {
		if (!$this->discountCodeUsages->contains($discountCodeUsage)) {
			$this->discountCodeUsages->add($discountCodeUsage);
			$discountCodeUsage->setRelatedOrder($this);
		}

		return $this;
	}

	public function removeDiscountCodeUsage(DiscountCodeUsage $discountCodeUsage): static {
		if ($this->discountCodeUsages->removeElement($discountCodeUsage)) {
			// set the owning side to null (unless already changed)
			if ($discountCodeUsage->getRelatedOrder() === $this) {
				$discountCodeUsage->setRelatedOrder(null);
			}
		}

		return $this;
	}

}
