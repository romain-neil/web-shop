<?php

namespace App\Entity\Logs;

use App\Repository\Logs\AuditLogRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AuditLogRepository::class)]
#[ORM\Table(name: 'logs.audit_log')]
class AuditLog {
	
	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column]
	private ?int $id = null;
	
	#[ORM\Column(name: 'author_id', type: 'integer', nullable: true)]
	private ?int $author = null;
	
	#[ORM\Column(type: 'datetime', nullable: true)]
	private ?\DateTimeInterface $dateCreated = null;
	
	#[ORM\Column(length: 255)]
	private ?string $action = null;
	
	#[ORM\Column(length: 255, nullable: true)]
	private ?string $field = null;
	
	#[ORM\Column(length: 255, nullable: true)]
	private ?string $oldValue = null;
	
	#[ORM\Column(length: 255, nullable: true)]
	private ?string $newValue = null;
	
	public function getAuthor(): ?int {
		return $this->author;
	}
	
	public function setAuthor(?int $author): static {
		$this->author = $author;
		
		return $this;
	}
	
	public function getDateCreated(): ?\DateTimeInterface {
		return $this->dateCreated;
	}
	
	public function setDateCreated(?\DateTimeInterface $dateCreated): void {
		$this->dateCreated = $dateCreated;
	}
	
	public function getAction(): ?string {
		return $this->action;
	}
	
	public function setAction(string $action): static {
		$this->action = $action;
		
		return $this;
	}
	
	public function getField(): ?string {
		return $this->field;
	}
	
	public function setField(?string $field): void {
		$this->field = $field;
	}
	
	public function getOldValue(): ?string {
		return $this->oldValue;
	}
	
	public function setOldValue(?string $oldValue): static {
		$this->oldValue = $oldValue;
		
		return $this;
	}
	
	public function getNewValue(): ?string {
		return $this->newValue;
	}
	
	public function setNewValue(string $newValue): static {
		$this->newValue = $newValue;
		
		return $this;
	}
	
}