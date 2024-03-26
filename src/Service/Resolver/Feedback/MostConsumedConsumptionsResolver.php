<?php

declare(strict_types=1);

namespace App\Service\Resolver\Feedback;

class MostConsumedConsumptionsResolver
{
    public function resolve(array $consumptions): array
    {
        unset($consumptions['total']);

        foreach ($consumptions as $key => $consumption) {
            if ($consumption['diff'] < 0) {
                unset($consumptions[$key]);
            }
        }

        function sortByConsumptionDesc($a, $b): int
        {
            return $b['consumption'] <=> $a['consumption'];
        }

        usort($consumptions, 'sortByConsumptionDesc');

        return $consumptions;
    }
}