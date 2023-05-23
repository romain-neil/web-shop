<?php
namespace Auth\Entity;

use Auth\Repository\StaffRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StaffRepository::class)]
class Staff extends User {

	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column]
	private ?int $id = null;

	public function getId(): ?int {
		return $this->id;
	}

}
