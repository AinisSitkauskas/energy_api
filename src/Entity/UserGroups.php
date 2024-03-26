<?php

declare(strict_types = 1);

namespace App\Entity;

use App\Repository\UserGroupsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserGroupsRepository::class)]
class UserGroups
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $isBigCity = null;

    #[ORM\Column]
    private ?bool $isPrivateHouse = null;

    #[ORM\Column]
    private ?int $minResidents = null;

    #[ORM\Column]
    private ?int $maxResidents = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function isIsBigCity(): ?bool
    {
        return $this->isBigCity;
    }

    public function setIsBigCity(bool $isBigCity): self
    {
        $this->isBigCity = $isBigCity;

        return $this;
    }

    public function isIsPrivateHouse(): ?bool
    {
        return $this->isPrivateHouse;
    }

    public function setIsPrivateHouse(bool $isPrivateHouse): self
    {
        $this->isPrivateHouse = $isPrivateHouse;

        return $this;
    }

    public function getMinResidents(): ?int
    {
        return $this->minResidents;
    }

    public function setMinResidents(int $minResidents): self
    {
        $this->minResidents = $minResidents;

        return $this;
    }

    public function getMaxResidents(): ?int
    {
        return $this->maxResidents;
    }

    public function setMaxResidents(int $maxResidents): self
    {
        $this->maxResidents = $maxResidents;

        return $this;
    }
}
