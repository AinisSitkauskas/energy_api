<?php

declare(strict_types=1);

namespace App\Service\Calculator;

use App\Entity\UserGroupEnergyConsumption;

class UserPositionByUserGroupCalculator
{
    public function calculate(array $consumptions, array $userGroupConsumptions): float
    {
        $position = 0;

        /**  @var UserGroupEnergyConsumption $userGroupConsumption */
        foreach ($userGroupConsumptions as $userGroupConsumption) {
            $position += $userGroupConsumption->getPercentage();

            if ((round($consumptions['total']['consumption'] / 25) * 25) == $userGroupConsumption->getAverageConsumption()) {
                break;
            }
        }

        return $position;
    }
}