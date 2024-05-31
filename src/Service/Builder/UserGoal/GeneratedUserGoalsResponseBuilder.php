<?php

declare(strict_types = 1);

namespace App\Service\Builder\UserGoal;

use App\Entity\UserGoals;

class GeneratedUserGoalsResponseBuilder
{
    public function build(array $userGoals): array
    {
        $response = [];

        /** @var UserGoals $userGoal */
        foreach ($userGoals as $userGoal) {
            $response[] = [
                'percentage' => $userGoal->getPercentage(),
                'goal' => $userGoal->getGoal(),
                'date_from' => $userGoal->getDateFrom()->format('Y-m-d'),
                'date_to' => $userGoal->getDateTo()->format('Y-m-d'),
            ];
        }

        return $response;
    }
}