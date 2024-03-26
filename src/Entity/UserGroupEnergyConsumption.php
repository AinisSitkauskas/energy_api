<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\UserGroupEnergyConsumptionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserGroupEnergyConsumptionRepository::class)]
class UserGroupEnergyConsumption
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: "App\Entity\UserGroups")]
    #[ORM\JoinColumn(name: "user_group_id", referencedColumnName: "id")]
    private ?UserGroups $userGroup = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 13, scale: 2)]
    private ?float $averageConsumption = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 13, scale: 2)]
    private ?float $percentage = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, options: ["default" => "CURRENT_TIMESTAMP"])]
    private ?\DateTimeImmutable $createdAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getUserGroup(): ?UserGroups
    {
        return $this->userGroup;
    }

    public function setUserGroup(UserGroups $userGroup): self
    {
        $this->userGroup = $userGroup;

        return $this;
    }

    public function getAverageConsumption(): ?float
    {
        return $this->averageConsumption;
    }

    public function setAverageConsumption(float $averageConsumption): self
    {
        $this->averageConsumption = $averageConsumption;

        return $this;
    }

    public function getPercentage(): ?float
    {
        return $this->percentage;
    }

    public function setPercentage(float $percentage): self
    {
        $this->percentage = $percentage;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
