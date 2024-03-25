<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\UsersRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UsersRepository::class)]
class Users
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $username = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column]
    private ?bool $hasFeedbackReport = null;
    
    #[ORM\OneToOne(targetEntity: "App\Entity\UserInformation", mappedBy: "user")]
    private ?UserInformation $userInformation = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): ?self
    {
        $this->id = $id;
        
        return $this;
    }
    
    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function isHasFeedbackReport(): ?bool
    {
        return $this->hasFeedbackReport;
    }

    public function setHasFeedbackReport(bool $hasFeedbackReport): self
    {
        $this->hasFeedbackReport = $hasFeedbackReport;

        return $this;
    }
    
    public function getUserInformation(): ?UserInformation
    {
        return $this->userInformation;
    }
    
    public function setUserInformation(UserInformation $userInformation): self
    {
        $this->userInformation = $userInformation;
        
        return $this;
    } 
}
