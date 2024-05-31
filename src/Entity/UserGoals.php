<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\UserGoalsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserGoalsRepository::class)]
class UserGoals
{
    public const GOAL_STATUS_IN_PROGRESS = 'in_progress';
    public const GOAL_STATUS_WAITING = 'waiting';
    public const GOAL_STATUS_SUCCESS = 'success';
    public const GOAL_STATUS_FAIL = 'fail';

    public const USER_GOALS = [
        self::GOAL_5_PERCENT,
        self::GOAL_10_PERCENT,
        self::GOAL_15_PERCENT,
    ];

    public const GOAL_5_PERCENT = 5;
    public const GOAL_10_PERCENT = 10;
    public const GOAL_15_PERCENT = 15;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: "App\Entity\Users")]
    #[ORM\JoinColumn(name: "user_id", referencedColumnName: "id")]
    private ?Users $user = null;

    #[ORM\Column(length: 255)]
    private ?string $status = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 13, scale: 2)]
    private ?float $predictedConsumption = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 13, scale: 2, options: ["default" => 0])]
    private ?float $consumption = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 13, scale: 2)]
    private ?float $goal = null;

    #[ORM\Column]
    private ?int $percentage = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, options: ["default" => "CURRENT_TIMESTAMP"])]
    private ?\DateTimeInterface $dateFrom = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, options: ["default" => "CURRENT_TIMESTAMP"])]
    private ?\DateTimeInterface $dateTo = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, options: ["default" => "CURRENT_TIMESTAMP"])]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, options: ["default" => "CURRENT_TIMESTAMP"])]
    private ?\DateTimeInterface $updatedAt = null;

    private bool $isGoodProgress;

    private string $progressMessage;

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

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getPredictedConsumption(): ?float
    {
        return $this->predictedConsumption;
    }

    public function setPredictedConsumption(float $predictedConsumption): self
    {
        $this->predictedConsumption = $predictedConsumption;

        return $this;
    }

    public function getConsumption(): ?float
    {
        return $this->consumption;
    }

    public function setConsumption(float $consumption): self
    {
        $this->consumption = $consumption;

        return $this;
    }

    public function getGoal(): ?float
    {
        return $this->goal;
    }

    public function setGoal(float $goal): self
    {
        $this->goal = $goal;

        return $this;
    }

    public function getPercentage(): ?int
    {
        return $this->percentage;
    }

    public function setPercentage(int $percentage): self
    {
        $this->percentage = $percentage;

        return $this;
    }

    public function getDateFrom(): ?\DateTimeInterface
    {
        return $this->dateFrom;
    }

    public function setDateFrom(?\DateTimeInterface $dateFrom): self
    {
        $this->dateFrom = $dateFrom;

        return $this;
    }

    public function getDateTo(): ?\DateTimeInterface
    {
        return $this->dateTo;
    }

    public function setDateTo(?\DateTimeInterface $dateTo): self
    {
        $this->dateTo = $dateTo;

        return $this;
    }


    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function isGoodProgress(): bool
    {
        return $this->isGoodProgress;
    }

    public function setIsGoodProgress(bool $isGoodProgress): void
    {
        $this->isGoodProgress = $isGoodProgress;
    }

    public function getProgressMessage(): string
    {
        return $this->progressMessage;
    }

    public function setProgressMessage(string $progressMessage): void
    {
        $this->progressMessage = $progressMessage;
    }
}
