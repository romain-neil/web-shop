<?php
namespace App\Entity;

use App\Repository\UserRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Scheb\TwoFactorBundle\Model\Totp\TotpConfiguration;
use Scheb\TwoFactorBundle\Model\Totp\TotpConfigurationInterface;
use Scheb\TwoFactorBundle\Model\Totp\TwoFactorInterface;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use function count;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\InheritanceType('JOINED')]
#[ORM\DiscriminatorColumn(name: 'discr', type: 'string')]
#[ORM\DiscriminatorMap([
	'staff' => 'Staff',
	'cust' => 'Customer'
])]
#[ORM\Table(name: '`user`')]
class User implements UserInterface, PasswordAuthenticatedUserInterface, TwoFactorInterface, EquatableInterface {

	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column(type: 'integer')]
	private int $id;

	#[ORM\Column(type: 'string', length: 180, unique: true)]
	private string $email;

	#[ORM\Column(type: 'json')]
	private array $roles = [];

	#[ORM\Column(type: 'string', length: 255)]
	#[Assert\Type(type: 'alpha')]
	private string $nom;

	#[ORM\Column(type: 'string', length: 255)]
	#[Assert\Type(type: 'alpha')]
	private string $prenom;

	#[ORM\Column(type: 'string', length: 255)]
	private string $password;

	#[ORM\Column(type: 'boolean', options: ['default' => false])]
	private bool $isActivated;

	#[ORM\Column(type: 'datetime')]
	private DateTimeInterface $registerDate;

	#[ORM\Column(type: 'datetime', nullable: true)]
	private ?DateTimeInterface $lastLoginDate;

	#[ORM\Column(length: 255, nullable: true)]
	private ?string $mobile = null;

	#[ORM\Column(length: 255, nullable: true)]
	private ?string $totpSecret = null;

	#[ORM\Column(type: 'boolean', options: ['default' => false])]
	private ?bool $isTotpEnabled = null;

	public function __construct() {
		$this->notifications = new ArrayCollection();
	}

	public function getId(): ?int {
		return $this->id;
	}

	public function getUserId(): int {
		return $this->id;
	}

	public function getEmail(): string {
		return $this->email;
	}

	public function setEmail(string $email): self {
		$this->email = $email;

		return $this;
	}

	/**
	 * A visual identifier that represents this user.
	 *
	 * @see UserInterface
	 */
	public function getUserIdentifier(): string {
		return $this->email;
	}

	/**
	 * @deprecated since Symfony 5.3, use getUserIdentifier instead
	 */
	public function getUsername(): string {
		return $this->email;
	}

	/**
	 * @see UserInterface
	 */
	public function getRoles(): array {
		$roles = $this->roles;
		// guarantee every user at least has ROLE_USER
		$roles[] = 'ROLE_USER';

		return array_unique($roles);
	}

	public function setRoles(array $roles): self {
		$this->roles = $roles;

		return $this;
	}

	/**
	 * This method can be removed in Symfony 6.0 - is not needed for apps that do not check user passwords.
	 *
	 * @see PasswordAuthenticatedUserInterface
	 */
	public function getPassword(): ?string {
		return $this->password;
	}

	/**
	 * This method can be removed in Symfony 6.0 - is not needed for apps that do not check user passwords.
	 *
	 * @see UserInterface
	 */
	public function getSalt(): ?string {
		return null;
	}

	/**
	 * @see UserInterface
	 */
	public function eraseCredentials() { }

	public function getNom(): ?string {
		return $this->nom;
	}

	public function setNom(string $nom): self {
		$this->nom = $nom;

		return $this;
	}

	public function getPrenom(): ?string {
		return $this->prenom;
	}

	public function setPrenom(string $prenom): self {
		$this->prenom = $prenom;

		return $this;
	}

	public function setPassword(string $password): self {
		$this->password = $password;

		return $this;
	}

	public function getIsActivated(): bool {
		return $this->isActivated;
	}

	public function setIsActivated(bool $isActivated): self {
		$this->isActivated = $isActivated;

		return $this;
	}

	public function getPrettyName(): string {
		return $this->prenom . " " . mb_strtoupper($this->nom);
	}

	public function getRegisterDate(): ?DateTimeInterface {
		return $this->registerDate;
	}

	public function setRegisterDate(DateTimeInterface $registerDate): self {
		$this->registerDate = $registerDate;

		return $this;
	}

	public function getLastLoginDate(): ?DateTimeInterface {
		return $this->lastLoginDate;
	}

	public function setLastLoginDate(?DateTimeInterface $lastLoginDate): self {
		$this->lastLoginDate = $lastLoginDate;

		return $this;
	}

	public function hasMobile(): bool {
		return $this->mobile !== null;
	}

	private function isEnabled(): bool {
		return $this->getIsActivated();
	}

	/**
	 * {@inheritdoc}
	 */
	public function isEqualTo(UserInterface $user): bool {
		if (!$user instanceof self) {
			return false;
		}

		if ($this->getPassword() !== $user->getPassword()) {
			return false;
		}

		$currentRoles = array_map('strval', $this->getRoles());
		$newRoles = array_map('strval', $user->getRoles());
		$rolesChanged = count($currentRoles) !== count($newRoles) || count($currentRoles) !== count(array_intersect($currentRoles, $newRoles));

		if ($rolesChanged) {
			return false;
		}

		if ($this->getUserIdentifier() !== $user->getUserIdentifier()) {
			return false;
		}

		if ($this->isEnabled() !== $user->isEnabled()) {
			return false;
		}

		return true;
	}

	public function __toString(): string {
		return $this->getPrettyName();
	}

	/**
	 * Return user fancy name (e.g. Peter Matthews as Peter MATTHEWS)
	 * @return string
	 */
	public function getFancyName(): string {
		return sprintf("%s %s", $this->prenom, strtoupper($this->nom));
	}

	public function getMobile(): ?string {
		return $this->mobile;
	}

	public function setMobile(?string $mobile): self {
		$this->mobile = $mobile;

		return $this;
	}

	/**
	 * @param string|null $totpSecret
	 */
	public function setTotpSecret(?string $totpSecret): void {
		$this->totpSecret = $totpSecret;
	}

	public function isTotpAuthenticationEnabled(): bool {
		return $this->getIsTotpEnabled();
	}

	public function getTotpAuthenticationUsername(): string {
		return $this->getUserIdentifier();
	}

	public function getTotpAuthenticationConfiguration(): ?TotpConfigurationInterface {
		return new TotpConfiguration($this->totpSecret, TotpConfiguration::ALGORITHM_SHA1, 30, 6);
	}

	/**
	 * @return bool|null
	 */
	public function getIsTotpEnabled(): ?bool {
		return $this->isTotpEnabled;
	}

	/**
	 * @param bool|null $isTotpEnabled
	 */
	public function setIsTotpEnabled(?bool $isTotpEnabled): void {
		$this->isTotpEnabled = $isTotpEnabled;
	}

}
