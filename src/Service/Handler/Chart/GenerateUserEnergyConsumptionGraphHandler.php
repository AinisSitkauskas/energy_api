<?php

declare(strict_types = 1);

namespace App\Service\Handler\Chart;

use App\Entity\Users;
use App\Repository\EnergyDailyConsumptionRepository;
use App\Service\Builder\Chart\ChartDatasetBuilder;
use App\Service\Formatter\Chart\ConsumptionByPercentageFormatter;
use App\Service\Formatter\Feedback\ConsumptionDataFormatter;

class GenerateUserEnergyConsumptionGraphHandler
{
    public function __construct(
        private readonly ConsumptionByPercentageFormatter $consumptionByPercentageFormatter,
        private readonly ConsumptionDataFormatter $consumptionDataFormatter,
        private readonly ChartDatasetBuilder $chartDatasetBuilder,
        private readonly EnergyDailyConsumptionRepository $energyDailyConsumptionRepository,
    ) {
    }

    public function handle(Users $user): array
    {
        $consumptions = $this->energyDailyConsumptionRepository->findUserConsumptionBetweenDates($user, (new \DateTime('1 week ago'))->setTime(0, 0), new \DateTime());
        $formattedConsumptions = $this->consumptionDataFormatter->format($consumptions);
        $consumptionsByPercentage = $this->consumptionByPercentageFormatter->format($formattedConsumptions);

        $datasets = $this->chartDatasetBuilder->build($consumptionsByPercentage);

        return [
            'labels' => [''], // Categories for the chart
            'datasets' => $datasets,
            'imageName' => $user->getId() . '_' . (new \DateTime())->format('Y-m-d') . '.png',
        ];
    }
}