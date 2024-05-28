<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\EnergyTypesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EnergyTypesRepository::class)]
class EnergyTypes
{
    public const FOOD_INDEX = 1;
    public const ELECTRICITY_INDEX = 2;
    public const WASTE_INDEX = 3;
    public const SHOP_INDEX = 4;
    public const TRANSPORT_INDEX = 5;
    public const FUEL_INDEX = 6;
    public const HEAT_INDEX = 7;
    public const WATER_INDEX = 8;

    public const ENERGY_TYPES = [
        self::FOOD_INDEX,
        self::ELECTRICITY_INDEX,
        self::WASTE_INDEX,
        self::SHOP_INDEX,
        self::TRANSPORT_INDEX,
        self::FUEL_INDEX,
        self::HEAT_INDEX,
        self::WATER_INDEX,
    ];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    public function getId(): ?int
    {
        return $this->id;
    }
    
    public function setId(int $id): self
    {
        $this->id = $id;
        
        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }
}
