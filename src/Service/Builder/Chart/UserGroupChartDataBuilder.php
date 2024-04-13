<?php

declare(strict_types=1);

namespace App\Service\Builder\Chart;

use App\Entity\UserGroupEnergyConsumption;
use App\Entity\Users;

class UserGroupChartDataBuilder
{
    public const BASIC_BACKGROUND_COLOUR = 'rgba(75, 192, 192, 0.5)';
    public const BASIC_BORDER_COLOUR = 'rgba(75, 192, 192, 1)';

    public const USER_BACKGROUND_COLOUR = 'rgba(0, 255, 255, 0.5)';
    public const USER_BORDER_COLOUR = 'rgba(0, 255, 255, 1)';

    public function build(Users $user, array $consumptions, array $userGroupConsumptions): array
    {
        $labels = [];
        $data = [];
        $backgroundColours = [];
        $borderColours = [];

        /**  @var UserGroupEnergyConsumption $userGroupConsumption */
        foreach ($userGroupConsumptions as $userGroupConsumption) {
            $labels[] = $userGroupConsumption->getAverageConsumption();
            $data[] = $userGroupConsumption->getPercentage();

            if ((round($consumptions['total']['consumption'] / 50) * 50) == $userGroupConsumption->getAverageConsumption()) {
                $backgroundColours[] = self::USER_BACKGROUND_COLOUR;
                $borderColours[] = self::USER_BORDER_COLOUR;
            } else {
                $backgroundColours[] = self::BASIC_BACKGROUND_COLOUR;
                $borderColours[] = self::BASIC_BORDER_COLOUR;
            }
        }

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'CO2 Footprint',
                    'data' => $data,
                    'backgroundColor' => $backgroundColours,
                    'borderColor' => $borderColours,
                    'borderWidth' => 1,
                    'categoryPercentage' => 0.8,
                    'barPercentage' => 0.7
                ]
            ],
            'imageName' => $user->getId() . '_' . (new \DateTime())->format('Y-m-d') . '_user_group.png',
        ];
    }
}