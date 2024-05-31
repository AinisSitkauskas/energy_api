<?php

declare(strict_types = 1);

namespace App\Service\Calculator\UserGoal;

use App\Entity\EnergyMonthlyConsumption;
use App\Entity\EnergyTypes;
use App\Entity\UserInformation;
use App\Entity\Users;
use App\Repository\EnergyMonthlyConsumptionRepository;
use App\Repository\UserGroupByEnergyTypeConsumptionsRepository;
use Phpml\Regression\LeastSquares;

class NextMonthsConsumptionCalculator
{
    public const AVERAGE_OUTSIDE_TEMPERATURE = [
        '01' => -4,
        '02' => -4,
        '03' => 0,
        '04' => 7,
        '05' => 13,
        '06' => 16,
        '07' => 18,
        '08' => 17,
        '09' => 12,
        '10' => 7,
        '11' => 2,
        '12' => -2,
    ];

    //cold month season = 0 , hot month season = 1
    public const MONTHS_SEASONS = [
        '01' => 0,
        '02' => 0,
        '03' => 0,
        '04' => 1,
        '05' => 1,
        '06' => 1,
        '07' => 1,
        '08' => 1,
        '09' => 1,
        '10' => 0,
        '11' => 0,
        '12' => 0,
    ];

    public const AVERAGE_INSIDE_TEMPERATURE = 20;

    public const FUEL_TYPE_COEFFICIENTS = [
        UserInformation::FUEL_TYPE_NATURAL_GAS => 0.22,
        UserInformation::FUEL_TYPE_FIREWOOD => 0.04,
        UserInformation::FUEL_TYPE_COAL => 0.36,
        UserInformation::FUEL_TYPE_BRIQUETTES => 0.04,
        UserInformation::FUEL_TYPE_PROPANE_BHUTAN => 0.4,
        UserInformation::FUEL_TYPE_ELECTRICITY => 0.22,
    ];

    public const MAX_ELECTRICITY_RESULTS = 24;

    public function __construct(
        private readonly EnergyMonthlyConsumptionRepository $energyMonthlyConsumptionRepository,
        private readonly UserGroupByEnergyTypeConsumptionsRepository $userGroupByEnergyTypeConsumptionsRepository,
    ) {
    }

    public function calculate(Users $user): float
    {
        $totalConsumption = 0;

        // foreach each energy type
        foreach (EnergyTypes::ENERGY_TYPES as $energyType) {
            switch ($energyType) {
                case EnergyTypes::ELECTRICITY_INDEX:
                    $consumptions = $this->energyMonthlyConsumptionRepository->findByUserAndEnergyType($user, $energyType, self::MAX_ELECTRICITY_RESULTS);
                    if ($consumptions) {
                        $consumption = $this->calculateElectricity($user, $consumptions);
                    } else {
                        $consumption = $this->userGroupByEnergyTypeConsumptionsRepository->findByUserGroupAndEnergyType($user->getUserInformation()->getUserGroup()->getId(), $energyType)->getAverageConsumption();
                    }
                    break;
                case EnergyTypes::HEAT_INDEX:
                    $consumptions = $this->energyMonthlyConsumptionRepository->findByUserAndEnergyType($user, $energyType);
                    if ($consumptions) {
                        $consumption = $this->calculateHeat($user, $consumptions);
                    } else {
                        $consumption = $this->userGroupByEnergyTypeConsumptionsRepository->findByUserGroupAndEnergyType($user->getUserInformation()->getUserGroup()->getId(), $energyType)->getAverageConsumption();
                    }
                    break;
                default:
                    $consumptions = $this->energyMonthlyConsumptionRepository->findByUserAndEnergyType($user, $energyType);
                    $consumption = $consumptions ? $consumptions->getConsumption() : $this->userGroupByEnergyTypeConsumptionsRepository->findByUserGroupAndEnergyType($user->getUserInformation()->getUserGroup()->getId(), $energyType)->getAverageConsumption();
            }

            $totalConsumption += $consumption;
        }

        return $totalConsumption;
    }

    private function calculateElectricity(Users $user, array $consumptions): float
    {
        // sorting consumptions for features and targets
        foreach ($consumptions as $key => $consumption) {
            $nextKey = $key + 1;
            if (isset($consumptions[$nextKey])) {
                $features[] = [$consumption->getConsumption(), self::MONTHS_SEASONS[$consumption->getCreatedAt()->format('m')]];
                $targets[] = $consumptions[$nextKey]->getConsumption();
            }
        }

        // training model
        $regression = new LeastSquares();
        $regression->train($features, $targets);

        $latestMonth = [end($consumptions)->getConsumption(), self::MONTHS_SEASONS[end($consumptions)->getCreatedAt()->format('m')]];

        // predicting consumption
        return current($regression->predict([$latestMonth]));
    }

    private function calculateHeat(Users $user, EnergyMonthlyConsumption $lastMonthHeat): float
    {
        $information = $user->getUserInformation();

        $now = new \DateTime();
        $oneMonthAgo = new \DateTime('-1 month');

        $currentDay = $now->format('d');

        if ((int)$currentDay >= 15) {
            $now->modify('first day of next month');
            $oneMonthAgo = new \DateTime();
        }

        $month = $now->format('m');
        $monthAgo = $oneMonthAgo->format('m');

        // finding parameters determined by last month
        $hdd = self::AVERAGE_INSIDE_TEMPERATURE - self::AVERAGE_OUTSIDE_TEMPERATURE[$month];
        $hddLastMonth = self::AVERAGE_INSIDE_TEMPERATURE - self::AVERAGE_OUTSIDE_TEMPERATURE[$monthAgo];

        $energyLastMonth = $information->getFuelType() ? $lastMonthHeat->getConsumption() / self::FUEL_TYPE_COEFFICIENTS[$information->getFuelType()] : $lastMonthHeat->getConsumption() / self::FUEL_TYPE_COEFFICIENTS['default'];

        // predicting energy
        $predictedEnergy = $energyLastMonth / $hddLastMonth * $hdd;

        return $information->getFuelType() ? $predictedEnergy * self::FUEL_TYPE_COEFFICIENTS[$information->getFuelType()] : $predictedEnergy * self::FUEL_TYPE_COEFFICIENTS['default'];
    }
}