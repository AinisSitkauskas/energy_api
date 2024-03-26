<?php

declare(strict_types=1);

namespace App\Service\Resolver\Feedback;

class MostSavedConsumptionsResolver
{
    public function resolve(array $consumptions): array
    {
        unset($consumptions['total']);

        foreach ($consumptions as $key => $consumption) {
            if ($consumption['diff'] > 0) {
                unset($consumptions[$key]);
            }
        }

        function sortByConsumptionAsc($a, $b): int
        {
            return $a['consumption'] <=> $b['consumption'];
        }

        usort($consumptions, 'sortByConsumptionAsc');

        return $consumptions;
    }
}