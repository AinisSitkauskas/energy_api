<?php

declare(strict_types=1);

namespace App\Service\Calculator\UserGoal;

use App\Entity\Users;

class UserGoalCalculator
{
    public function calculate(Users $user, float $predictedConsumption, int $percentage): ?float
    {
        $goal = $predictedConsumption - ($predictedConsumption * $percentage / 100);

        if ($goal < $user->getUserInformation()->getUserGroup()->getMinConsumption()) {
            return null;
        }

        return round($goal, 2);
    }
}