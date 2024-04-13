<?php

declare(strict_types = 1);

namespace App\Service\Handler\Chart;

use App\Entity\Users;
use App\Repository\EnergyDailyConsumptionRepository;
use App\Repository\UserGroupEnergyConsumptionRepository;
use App\Service\Builder\Chart\UserGroupChartDataBuilder;
use App\Service\Formatter\Feedback\ConsumptionDataFormatter;

class GenerateUserGroupGraphHandler
{
    public function __construct(
        private readonly ConsumptionDataFormatter $consumptionDataFormatter,
        private readonly EnergyDailyConsumptionRepository $energyDailyConsumptionRepository,
        private readonly UserGroupChartDataBuilder $userGroupChartDataBuilder,
        private readonly UserGroupEnergyConsumptionRepository $userGroupEnergyConsumptionRepository,
    ) {
    }
    public function handle(Users $user): array
    {
        $consumptions = $this->energyDailyConsumptionRepository->findUserConsumptionBetweenDates($user, (new \DateTime('1 week ago'))->setTime(0, 0), new \DateTime());
        $formattedConsumptions = $this->consumptionDataFormatter->format($consumptions);
        $userGroupConsumptions = $this->userGroupEnergyConsumptionRepository->findUserGroupConsumptions($user);

        return $this->userGroupChartDataBuilder->build($user, $formattedConsumptions, $userGroupConsumptions);
    }
}