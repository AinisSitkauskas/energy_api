<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\EnergyMonthlyConsumptionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EnergyMonthlyConsumptionRepository::class)]
class EnergyMonthlyConsumption
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: "App\Entity\Users")]
    #[ORM\JoinColumn(name: "user_id", referencedColumnName: "id")]
    private ?Users $user = null;
    
    #[ORM\ManyToOne(targetEntity: "App\Entity\EnergyTypes")]
    #[ORM\JoinColumn(name: "energy_type_id", referencedColumnName: "id")]
    private ?EnergyTypes $energyType = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 13, scale: 5)]
    private ?string $consumption = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, options: ["default" => "CURRENT_TIMESTAMP"])]
    private ?\DateTimeImmutable $createdAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): ?self
    {
        $this->id = $id;
        
        return $this;
    }
    
    public function getUser(): ?Users
    {
        return $this->user;
    }
    
    public function setUser(Users $user): self
    {
        $this->user = $user;
        
        return $this;
    }
    
    public function getEnergyType(): ?EnergyTypes
    {
        return $this->energyType;
    }
    
    public function setEnergyType(EnergyTypes $energyType): self
    {
        $this->energyType = $energyType;
        
        return $this;
    }

    public function getConsumption(): ?string
    {
        return $this->consumption;
    }

    public function setConsumption(string $consumption): static
    {
        $this->consumption = $consumption;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}