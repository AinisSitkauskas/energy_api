<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\UserInformationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserInformationRepository::class)]
class UserInformation
{
    PUBLIC const HOUSE_TYPE_PRIVATE = 'private';
    PUBLIC const HOUSE_TYPE_APARTMENT = 'apartment';

    PUBLIC const HEAT_TYPE_CENTRAL = 'central';
    PUBLIC const HOUSE_TYPE_INDIVIDUAL = 'individual';

    PUBLIC const FUEL_TYPE_NATURAL_GAS = 'natural_gas';
    PUBLIC const FUEL_TYPE_FIREWOOD = 'firewood';
    PUBLIC const FUEL_TYPE_COAL = 'coal';
    PUBLIC const FUEL_TYPE_BRIQUETTES = 'briquettes';
    PUBLIC const FUEL_TYPE_PROPANE_BHUTAN = 'propane_bhutan';
    PUBLIC const FUEL_TYPE_ELECTRICITY = 'electricity';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    
    #[ORM\OneToOne(targetEntity: "App\Entity\Users")]
    #[ORM\JoinColumn(name: "user_id", referencedColumnName: "id")]
    private ?Users $user = null;

    #[ORM\ManyToOne(targetEntity: "App\Entity\UserGroups")]
    #[ORM\JoinColumn(name: "user_group_id", referencedColumnName: "id")]
    private ?UserGroups $userGroup = null;

    #[ORM\Column(length: 255)]
    private ?string $city = null;

    #[ORM\Column]
    private ?int $residents = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $houseType = null;

    #[ORM\Column(nullable: true)]
    private ?int $livingArea = null;

    #[ORM\Column(length: 255)]
    private ?string $heatType = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 13, scale: 1)]
    private ?float $monthlyHeatConsumption;

    #[ORM\Column(length: 255)]
    private ?string $fuelType;

    #[ORM\Column(type: Types::DECIMAL, precision: 13, scale: 1)]
    private  ?string $fuelConsumption;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
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
    
    public function getUserGroup(): ?UserGroups
    {
        return $this->userGroup;
    }
    
    public function setUserGroup(UserGroups $userGroup): self
    {
        $this->userGroup = $userGroup;
        
        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getResidents(): ?int
    {
        return $this->residents;
    }

    public function setResidents(int $residents): self
    {
        $this->residents = $residents;

        return $this;
    }

    public function getHouseType(): ?string
    {
        return $this->houseType;
    }

    public function setHouseType(?string $houseType): self
    {
        $this->houseType = $houseType;

        return $this;
    }

    public function getLivingArea(): ?int
    {
        return $this->livingArea;
    }

    public function setLivingArea(?int $livingArea): self
    {
        $this->livingArea = $livingArea;

        return $this;
    }

    public function getHeatType(): ?string
    {
        return $this->heatType;
    }

    public function setHeatType(?string $heatType): self
    {
        $this->heatType = $heatType;

        return $this;
    }

    public function getMonthlyHeatConsumption(): ?float
    {
        return $this->monthlyHeatConsumption;
    }

    public function setMonthlyHeatConsumption(?float $monthlyHeatConsumption): self
    {
        $this->monthlyHeatConsumption = $monthlyHeatConsumption;

        return $this;
    }

    public function getFuelType(): ?string
    {
        return $this->fuelType;
    }

    public function setFuelType(?string $fuelType): self
    {
        $this->fuelType = $fuelType;

        return $this;
    }

    public function getFuelConsumption(): ?string
    {
        return $this->fuelConsumption;
    }

    public function setFuelConsumption(?string $fuelConsumption): self
    {
        $this->fuelConsumption = $fuelConsumption;

        return $this;
    }
}
