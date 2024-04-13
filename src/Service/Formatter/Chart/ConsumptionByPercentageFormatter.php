<?php

declare(strict_types=1);

namespace App\Service\Formatter\Chart;

class ConsumptionByPercentageFormatter
{
    public function format(array $consumptions): array
    {
        $other = 0;

        foreach ($consumptions as $key => $consumption) {
            if ($key === 'total') {
                continue;
            }

            $percentage = $consumption['consumption'] / $consumptions['total']['consumption'] * 100;

            $roundedDownPercentage = floor($percentage * 100) / 100;

            if ($roundedDownPercentage < 1) {
                $other += $roundedDownPercentage;
                unset($consumptions[$key]);
            } else {
                $consumptions[$key]['percentage'] = $roundedDownPercentage;
            }
        }

        if ($other > 0) {
            $consumptions['other']['percentage'] = $other;
            $consumptions['other']['title'] = 'Kita';
        }

        return $consumptions;
    }
}