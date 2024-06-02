<?php

declare(strict_types=1);

namespace App\Service\Builder\Email;

use App\Entity\UserGoals;
use App\Entity\Users;
use Twig\Environment as TwigEnvironment;

class EmailTemplateBuilder
{
    public function __construct(private readonly TwigEnvironment $twig)
    {
    }

    public function build(
        array $consumptions,
        array $mostSavedConsumptions,
        array $mostConsumedConsumptions,
        float $userGroupPosition,
        ?UserGoals $userGoal,
        string $advices,
        string $consumptionChart,
        string $userGroupChartChart
    ): string
    {
        return $this->twig->render('feedback/report.html.twig', [
            'last_week_date' => (new \DateTime('1 week ago'))->format('Y-m-d'),
            'current_date' => (new \DateTime())->format('Y-m-d'),
            'total_consumption' => $consumptions['total']['consumption'],
            'consumption_chart' => $consumptionChart,
            'most_saved_consumptions' => $mostSavedConsumptions,
            'most_consumed_consumptions' => $mostConsumedConsumptions,
            'user_group_chart' => $userGroupChartChart,
            'user_group_position' => $userGroupPosition,
            'user_goal' => $userGoal,
            'advices' => $advices,
        ]);
    }
}