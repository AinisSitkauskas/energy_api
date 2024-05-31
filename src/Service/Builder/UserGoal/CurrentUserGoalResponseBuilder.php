<?php

declare(strict_types = 1);

namespace App\Service\Builder\UserGoal;

use App\Entity\UserGoals;

class CurrentUserGoalResponseBuilder
{
    public function build(UserGoals $userGoal): array
    {
        return [
            'percentage' => $userGoal->getPercentage(),
            'date_from' => $userGoal->getDateFrom()->format('Y-m-d'),
            'date_to' => $userGoal->getDateTo()->format('Y-m-d'),
            'goal' => $userGoal->getGoal(),
            'consumption' => $userGoal->getConsumption(),
            'is_good_progress' => $userGoal->getConsumption(),
            'progress_message' => $userGoal->getProgressMessage(),
            'updated_at' => $userGoal->getUpdatedAt()->format('Y-m-d H:i:s'),
        ];
    }
}