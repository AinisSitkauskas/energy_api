<?php

declare(strict_types=1);

namespace App\Service\Resolver\UserGoal;

use App\Entity\UserGoals;

class UserGoalProgressResolver
{
    public const GOOD_PROGRESS = ' kg lenkiate planuojamą pėdsaką šiai dienai !';
    public const BAD_PROGRESS = ' kg atsiliekate nuo planuojamo pėdsako šiai dienai';

    public function resolve(UserGoals $userGoal): UserGoals
    {
        $dateFrom = $userGoal->getDateFrom();
        $dateTo = $userGoal->getDateTo();
        $currentDay = new \DateTime();

        if ($userGoal->getDateFrom()->format('Y-m-d') === $currentDay->format('Y-m-d')) {
            $userGoal->setIsGoodProgress(true);
            $userGoal->setProgressMessage(0 . self::GOOD_PROGRESS);

            return $userGoal;
        }

        $goalDays = $dateTo->diff($dateFrom, true);
        $oneDayGoal = $userGoal->getGoal() / $goalDays->d;

        $currentDaysInProgress = $currentDay->diff($dateFrom, true);
        $predictedConsumption = $currentDaysInProgress->d * $oneDayGoal;

        if ($predictedConsumption <= $userGoal->getConsumption()) {
            $userGoal->setIsGoodProgress(true);
            $userGoal->setProgressMessage(round($predictedConsumption, 2) . self::GOOD_PROGRESS);
        } else {
            $userGoal->setIsGoodProgress(false);
            $userGoal->setProgressMessage(round($predictedConsumption, 2) . self::BAD_PROGRESS);
        }

        return $userGoal;
    }
}