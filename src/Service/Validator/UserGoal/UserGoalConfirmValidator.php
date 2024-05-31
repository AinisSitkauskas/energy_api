<?php

declare(strict_types=1);

namespace App\Service\Validator\UserGoal;

class UserGoalConfirmValidator
{
    public function validate(array $data): bool
    {
        if (!isset($data['percentage'])) {
            return false;
        }

        return true;
    }
}