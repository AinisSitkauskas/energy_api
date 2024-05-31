<?php

declare(strict_types=1);

namespace App\Service\Validator\User;
class UserRequestValidator
{
    public function validate(array $data): bool
    {
        if (!isset($data['user_id'])) {
            return false;
        }

        return true;
    }
}
