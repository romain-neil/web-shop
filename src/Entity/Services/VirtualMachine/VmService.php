<?php

namespace App\Entity\Services\VirtualMachine;

use App\Entity\Services\AbstractServicePlan;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\AbstractService;
use App\Repository\Services\VirtualMachine\VmServiceRepository;

#[ORM\Entity(repositoryClass: VmServiceRepository::class)]
#[ORM\Table(name: 'shop.vm_service')]
class VmService extends AbstractService {

	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column]
	protected ?int $id = null;

	#[ORM\ManyToOne]
	#[ORM\JoinColumn(nullable: true)]
	private ?OsDistribution $distrib = null;

	#[ORM\OneToMany(mappedBy: 'vm', targetEntity: VmBackup::class, orphanRemoval: true)]
	private Collection $backups;

	#[ORM\Column(nullable: true)]
	private ?int $vm_id = null;

	public function __construct() {
		$this->backups = new ArrayCollection();
	}

	public function getServiceName(): string {
		return 'Machine virtuelle ' . $this->getPlan()->getCommercialName();
	}

	public function getDistrib(): ?OsDistribution {
		return $this->distrib;
	}

	public function setDistrib(?OsDistribution $distrib): self {
		$this->distrib = $distrib;

		return $this;
	}

	/**
	 * @return Collection<int, VmBackup>
	 */
	public function getBackups(): Collection {
		return $this->backups;
	}

	public function addBackup(VmBackup $backup): self {
		if (!$this->backups->contains($backup)) {
			$this->backups->add($backup);
			$backup->setVm($this);
		}

		return $this;
	}

	public function removeBackup(VmBackup $backup): self {
		if ($this->backups->removeElement($backup)) {
			// set the owning side to null (unless already changed)
			if ($backup->getVm() === $this) {
				$backup->setVm(null);
			}
		}

		return $this;
	}

	public function getVmId(): ?int {
		return $this->vm_id;
	}

	public function setVmId(int $vm_id): self {
		$this->vm_id = $vm_id;

		return $this;
	}

	public function __toString(): string {
		return 'vm';
	}

}
