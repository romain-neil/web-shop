<?php
namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CustomerRepository;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CustomerRepository::class)]
#[ORM\Table(name: 'intranet.customer')]
class Customer extends User {

	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column]
	private ?int $id = null;

	#[ORM\Column(name: 'internal_client_id', type: 'integer', unique: true, nullable: true)]
	private ?int $internalClientId;

	#[ORM\Column(type: 'string', length: 255, nullable: true)]
	private ?string $client_code;

	#[ORM\Column]
	private ?bool $is_vat_liable = null;

	#[ORM\Column(length: 14, nullable: true)]
	private ?string $siret = null;

	#[ORM\Column(length: 255, nullable: true)]
	private ?string $address = null;

	#[ORM\Column(length: 5, nullable: true)]
	#[Assert\GreaterThan(value: 0, message: 'Code postal invalide')]
	private ?int $zip = null;

	#[ORM\Column(length: 255, nullable: true)]
	private ?string $city = null;

	/**
	 * Three letters Country Code (ISO 3166-1 alpha-2)
	 * @var string|null
	 */
	#[ORM\Column(length: 2, nullable: true)]
	private ?string $country = null;

	#[ORM\Column(length: 255, nullable: true)]
	private ?string $vat_number = null;

	public function getId(): ?int {
		return $this->id;
	}

	public function getInternalClientId(): ?int {
		return $this->internalClientId;
	}

	public function setInternalClientId(?int $internalClientId): self {
		$this->internalClientId = $internalClientId;

		return $this;
	}

	public function getClientCode(): ?string {
		return $this->client_code;
	}

	public function setClientCode(string $client_code): self {
		$this->client_code = $client_code;

		return $this;
	}

	public function isIsVatLiable(): ?bool {
		return $this->is_vat_liable;
	}

	public function setIsVatLiable(bool $is_vat_liable): self {
		$this->is_vat_liable = $is_vat_liable;

		return $this;
	}

	public function getSiret(): ?string {
		return $this->siret;
	}

	public function setSiret(?string $siret): self {
		$this->siret = $siret;

		return $this;
	}

	public function getAddress(): ?string {
		return $this->address;
	}

	public function setAddress(?string $address): self {
		$this->address = $address;

		return $this;
	}

	/**
	 * @return int|null
	 */
	public function getZip(): ?int {
		return $this->zip;
	}

	/**
	 * @param int|null $zip
	 */
	public function setZip(?int $zip): void {
		$this->zip = $zip;
	}

	public function getCity(): ?string {
		return $this->city;
	}

	public function setCity(?string $city): self {
		$this->city = $city;

		return $this;
	}

	public function getCountry(): ?string {
		return $this->country;
	}

	public function setCountry(?string $country): self {
		$this->country = $country;

		return $this;
	}

	public function getVatNumber(): ?string {
		return $this->vat_number;
	}

	public function setVatNumber(?string $vat_number): self {
		$this->vat_number = $vat_number;

		return $this;
	}

}
