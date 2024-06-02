<?php

declare(strict_types=1);

namespace App\Service\Resolver\UserGoal;

use App\Entity\UserGoals;

class UserGoalResultResolver
{
    public const GOOD_RESULT = 'Jums pavyko sumažinti savo CO2 pėdsaką %d kg';
    public const REDUCED_RESULT = 'Jums nepavyko pasiekti tikslo, tačiau jūs sumažinote savo CO2 pėdsaką %d kg. Toliau prisidėkite prie emisijos mažinimo ir siūlome pasirinkti naują tikslą.';
    public const BAD_RESULT = 'Jums nepavyko pasiekti tikslo. Siūlome pasiskaityti mūsų rekomendacinius patarimus ir mėginti dar kartą nusistatyti sau naują tikslą.';

    public function resolve(UserGoals $userGoal): UserGoals
    {
        if ($userGoal->getConsumption() <= $userGoal->getGoal()) {
            $diff = ($userGoal->getPredictedConsumption() - $userGoal->getConsumption()) / $userGoal->getPredictedConsumption() * 100;
            $userGoal->setIsGoodProgress(true);
            $userGoal->setProgressMessage(sprintf(self::GOOD_RESULT, round($diff)));
        } elseif ($userGoal->getConsumption() <= $userGoal->getPredictedConsumption()) {
            $diff = ($userGoal->getPredictedConsumption() - $userGoal->getConsumption()) / $userGoal->getPredictedConsumption() * 100;
            $userGoal->setIsGoodProgress(true);
            $userGoal->setProgressMessage(sprintf(self::REDUCED_RESULT, round($diff)));
        } else {
            $userGoal->setIsGoodProgress(false);
            $userGoal->setProgressMessage(self::BAD_RESULT);
        }

        return $userGoal;
    }
}