<?php

declare(strict_types=1);

namespace App\Service\Formatter\Feedback;

use App\Entity\EnergyDailyConsumption;

class ConsumptionDataFormatter
{
    public function format(array $consumptions): array
    {
        $formattedConsumptions = [
            'total' => [
                'consumption' => 0,
            ],
        ];

        /** @var EnergyDailyConsumption $consumption */
        foreach ($consumptions as $consumption) {
            if (!isset($formattedConsumptions[$consumption->getEnergyType()->getId()])) {
                $formattedConsumptions[$consumption->getEnergyType()->getId()]['consumption'] = $consumption->getConsumption();
                $formattedConsumptions[$consumption->getEnergyType()->getId()]['title'] = $consumption->getEnergyType()->getType();

            } else {
                $formattedConsumptions[$consumption->getEnergyType()->getId()]['consumption'] += $consumption->getConsumption();
            }

            $formattedConsumptions['total']['consumption'] += $consumption->getConsumption();
        }

        return $formattedConsumptions;
    }
}