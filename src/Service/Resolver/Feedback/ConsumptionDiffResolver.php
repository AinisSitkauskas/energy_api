<?php

declare(strict_types=1);

namespace App\Service\Resolver\Feedback;

class ConsumptionDiffResolver
{
    public function resolve(array $consumptions, array $oldConsumptions): array
    {
        foreach ($consumptions as $consumptionKey => &$consumption) {
            $consumption['diff'] = 0;

            foreach ($oldConsumptions as $oldConsumptionKey => $oldConsumption) {
                if ($consumptionKey === $oldConsumptionKey) {
                    $consumption['diff'] = $consumption['consumption'] - $oldConsumption['consumption'];
                }
            }

        }

        return $consumptions;
    }
}