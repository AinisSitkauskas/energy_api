<?php

declare(strict_types = 1);

namespace App\Service\SaveHandler\UserGoal;

use App\Entity\UserGoals;
use Doctrine\ORM\EntityManagerInterface;

class UpdateUserGoalSaveHandler
{
    public function __construct(
        private readonly EntityManagerInterface $em,
    ) {
    }

    public function save(
        UserGoals $userGoal,
        string $status,
        ?float $consumption = null,
    ): UserGoals {
        $userGoal->setStatus($status);

        if ($consumption) {
            $userGoal->setConsumption($userGoal->getConsumption() + $consumption);
        }

        $this->em->flush();

        return $userGoal;
    }
}