<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\UserGroupByEnergyTypeConsumptionsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserGroupByEnergyTypeConsumptionsRepository::class)]
class UserGroupByEnergyTypeConsumptions
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: "App\Entity\UserGroups")]
    #[ORM\JoinColumn(name: "user_group_id", referencedColumnName: "id")]
    private ?UserGroups $userGroup = null;

    #[ORM\ManyToOne(targetEntity: "App\Entity\EnergyTypes")]
    #[ORM\JoinColumn(name: "energy_type_id", referencedColumnName: "id")]
    private ?EnergyTypes $energyType = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 13, scale: 2)]
    private ?float $averageConsumption = null;

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
    public function getEnergyType(): ?EnergyTypes
    {
        return $this->energyType;
    }

    public function setEnergyType(EnergyTypes $energyType): self
    {
        $this->energyType = $energyType;

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
}
