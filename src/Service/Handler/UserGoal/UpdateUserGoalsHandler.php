<?php

declare(strict_types=1);

namespace App\Service\Handler\UserGoal;

use App\Entity\UserGoals;
use App\Repository\EnergyDailyConsumptionRepository;
use App\Service\Formatter\Feedback\ConsumptionDataFormatter;
use App\Service\SaveHandler\UserGoal\UpdateUserGoalSaveHandler;

class UpdateUserGoalsHandler
{
    public function __construct(
        private readonly ConsumptionDataFormatter $consumptionDataFormatter,
        private readonly EnergyDailyConsumptionRepository $energyDailyConsumptionRepository,
        private readonly UpdateUserGoalSaveHandler $updateUserGoalSaveHandler,
    ) {
    }

    public function handle(UserGoals $userGoal): void
    {
        $consumptions = $this->energyDailyConsumptionRepository->findUserConsumptionBetweenDates($userGoal->getUser(), (new \DateTime('-1 day'))->setTime(0, 0), (new \DateTime())->setTime(0, 0));
        $consumptions = $this->consumptionDataFormatter->format($consumptions);

        $status = $userGoal->getDateTo()->format('Y-m-d') === (new \DateTime())->format('Y-m-d') ? UserGoals::GOAL_STATUS_FINISHED : UserGoals::GOAL_STATUS_IN_PROGRESS;

        $this->updateUserGoalSaveHandler->save($userGoal, $status, $consumptions['total']['consumption']);
    }
}