<?php

declare(strict_types=1);

namespace App\Service\Handler\UserGoal;

use App\Entity\UserGoals;
use App\Entity\Users;
use App\Repository\UserGoalsRepository;
use App\Service\Builder\UserGoal\GeneratedUserGoalsResponseBuilder;
use App\Service\Calculator\UserGoal\NextMonthsConsumptionCalculator;
use App\Service\Calculator\UserGoal\UserGoalCalculator;
use App\Service\SaveHandler\UserGoal\CreateUserGoalSaveHandler;

class GenerateUserGoalsHandler
{
    public function __construct(
        private readonly CreateUserGoalSaveHandler $createUserGoalSaveHandler,
        private readonly GeneratedUserGoalsResponseBuilder $generatedUserGoalsResponseBuilder,
        private readonly NextMonthsConsumptionCalculator $nextMonthsConsumptionCalculator,
        private readonly UserGoalCalculator $userGoalCalculator,
        private readonly UserGoalsRepository $userGoalsRepository,
    ) {
    }

    public function handle(Users $user): array
    {
        $predictedConsumption = $this->nextMonthsConsumptionCalculator->calculate($user);

        foreach (UserGoals::USER_GOALS as $userGoal) {
            $goal = $this->userGoalCalculator->calculate($user, $predictedConsumption, $userGoal);

            if (!$goal) {
                continue;
            }

            $this->createUserGoalSaveHandler->save(
                $user,
                $goal,
                $predictedConsumption,
                $userGoal
            );
        }

        $userGoals = $this->userGoalsRepository->findBy(['user' => $user, 'status' => UserGoals::GOAL_STATUS_WAITING]);

        return $this->generatedUserGoalsResponseBuilder->build($userGoals);
    }
}