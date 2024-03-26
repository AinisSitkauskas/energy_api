<?php

declare(strict_types=1);

namespace App\Service\Validator\Feedback;
class SendUserFeedbackValidator
{
    public function validate(array $data): bool
    {
        if (!isset($data['user_id'])) {
            return false;
        }

        return true;
    }
}
