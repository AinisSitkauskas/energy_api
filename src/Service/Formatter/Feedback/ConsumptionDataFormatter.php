<?php

declare(strict_types=1);

namespace App\Service\Formatter\Feedback;

use App\Entity\EnergyDailyConsumption;

class ConsumptionDataFormatter
{
    public function format(array $consumptions): array
    {
        $formattedConsumptions = [];

        /** @var EnergyDailyConsumption $consumption */
        foreach ($consumptions as $consumption) {
            $formattedConsumptions[$consumption->getEnergyType()->getId()]['consumption'] += $consumption->getConsumption();
            $formattedConsumptions[$consumption->getEnergyType()->getId()]['title'] += $consumption->getEnergyType()->getType();
            $formattedConsumptions['total']['consumption'] += $consumption->getConsumption();
        }

        return $formattedConsumptions;
    }
}