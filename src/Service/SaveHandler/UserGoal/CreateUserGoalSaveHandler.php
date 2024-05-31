<?php

declare(strict_types = 1);

namespace App\Service\SaveHandler\UserGoal;

use App\Entity\UserGoals;
use App\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;

class CreateUserGoalSaveHandler
{
    public function __construct(
        private readonly EntityManagerInterface $em,
    ) {
    }

    public function save(
        Users $user,
        float $goal,
        float $predictedConsumption,
        int $percentage
    ): void {
        $userGoal = new UserGoals();
        $userGoal->setUser($user);
        $userGoal->setGoal($goal);
        $userGoal->setPredictedConsumption($predictedConsumption);
        $userGoal->setPercentage($percentage);
        $userGoal->setStatus(UserGoals::GOAL_STATUS_WAITING);
        $userGoal->setDateFrom((new \DateTime())->setTime(0, 0));
        $userGoal->setDateTo((new \DateTime('+1 month'))->setTime(0, 0));

        $this->em->persist($userGoal);
        $this->em->flush();
    }
}