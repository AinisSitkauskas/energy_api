<?php

declare(strict_types=1);

namespace App\Service\Handler\UserGoal;

use App\Entity\UserGoals;
use App\Entity\Users;
use App\Repository\UserGoalsRepository;
use App\Service\Builder\UserGoal\CurrentUserGoalResponseBuilder;
use App\Service\Resolver\UserGoal\UserGoalProgressResolver;
use App\Service\Resolver\UserGoal\UserGoalResultResolver;

class GetUserGoalsHandler
{
    public function __construct(
        private readonly CurrentUserGoalResponseBuilder $currentUserGoalResponseBuilder,
        private readonly UserGoalProgressResolver $userGoalProgressResolver,
        private readonly UserGoalsRepository $userGoalsRepository,
        private readonly UserGoalResultResolver $userGoalResultResolver,
    ) {
    }

    public function handle(Users $user): array
    {
        $userGoal = $this->userGoalsRepository->findOneBy(['user' => $user, 'status' => UserGoals::GOAL_STATUS_IN_PROGRESS]);

        if ($userGoal) {
            $userGoal = $this->userGoalProgressResolver->resolve($userGoal);

            return $this->currentUserGoalResponseBuilder->build($userGoal);
        }

        $userGoal = $this->userGoalsRepository->findOneBy(['user' => $user, 'status' => UserGoals::GOAL_STATUS_FINISHED]);

        if ($userGoal) {
            $userGoal = $this->userGoalResultResolver->resolve($userGoal);

            return $this->currentUserGoalResponseBuilder->build($userGoal);
        }

        return [];
    }
}