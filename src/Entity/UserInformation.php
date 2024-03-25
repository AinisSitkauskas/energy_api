<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\UserInformationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserInformationRepository::class)]
class UserInformation
{
    PUBLIC const HOUSE_TYPE_PRIVATE = 'private';
    PUBLIC const HOUSE_TYPE_APARTMENT = 'apartment';
    
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

    public function setCity(string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getResidents(): ?int
    {
        return $this->residents;
    }

    public function setResidents(int $residents): static
    {
        $this->residents = $residents;

        return $this;
    }

    public function getHouseType(): ?string
    {
        return $this->houseType;
    }

    public function setHouseType(?string $houseType): static
    {
        $this->houseType = $houseType;

        return $this;
    }

    public function getLivingArea(): ?int
    {
        return $this->livingArea;
    }

    public function setLivingArea(?int $livingArea): static
    {
        $this->livingArea = $livingArea;

        return $this;
    }
}
