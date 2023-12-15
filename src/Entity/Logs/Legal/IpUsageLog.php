<?php

namespace App\Entity\Logs\Legal;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\Logs\Legal\IpUsageLogRepository;

#[ORM\Entity(repositoryClass: IpUsageLogRepository::class)]
#[ORM\Table(name: 'shop.ip_usage_log')]
class IpUsageLog {

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 45)]
    private ?string $ip = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_usage_start = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_usage_end = null;

    public function getId(): ?int {
        return $this->id;
    }

    public function getIp(): ?string {
        return $this->ip;
    }

    public function setIp(string $ip): self {
        $this->ip = $ip;

        return $this;
    }

    public function getDateUsageStart(): ?\DateTimeInterface {
        return $this->date_usage_start;
    }

    public function setDateUsageStart(\DateTimeInterface $date_usage_start): self {
        $this->date_usage_start = $date_usage_start;

        return $this;
    }

    public function getDateUsageEnd(): ?\DateTimeInterface {
        return $this->date_usage_end;
    }

    public function setDateUsageEnd(?\DateTimeInterface $date_usage_end): self {
        $this->date_usage_end = $date_usage_end;

        return $this;
    }

}
