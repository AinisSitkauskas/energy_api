<?php

declare(strict_types=1);

namespace App\Service\Resolver\Feedback;

class MostSavedConsumptionsResolver
{
    public function resolve(array $consumptions): array
    {
        unset($consumptions['total']);

        foreach ($consumptions as $key => $consumption) {
            if ($consumption['diff'] >= 0) {
                unset($consumptions[$key]);
            }
        }

        usort($consumptions, function ($a, $b) {
            return $a['diff'] <=> $b['diff'];
        });

        return $consumptions;
    }
}