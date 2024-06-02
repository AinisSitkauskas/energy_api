<?php

declare(strict_types=1);

namespace App\Service\Handler\Feedback;

use App\Entity\UserGoals;
use App\Entity\Users;
use App\Repository\EnergyDailyConsumptionRepository;
use App\Repository\UserGoalsRepository;
use App\Repository\UserGroupEnergyConsumptionRepository;
use App\Service\API\ChatGPTApi;
use App\Service\Builder\Advice\AdviceMessageRequestBuilder;
use App\Service\Builder\Email\EmailTemplateBuilder;
use App\Service\Calculator\UserGroup\UserPositionByUserGroupCalculator;
use App\Service\Formatter\Feedback\ConsumptionDataFormatter;
use App\Service\Resolver\Feedback\ConsumptionDiffResolver;
use App\Service\Resolver\Feedback\MostConsumedConsumptionsResolver;
use App\Service\Resolver\Feedback\MostSavedConsumptionsResolver;
use App\Service\Resolver\UserGoal\UserGoalProgressResolver;
use App\Service\Sender\EmailSender;

class SendUserFeedbackHandler
{
    public function __construct(
        private readonly AdviceMessageRequestBuilder $adviceMessageRequestBuilder,
        private readonly ChatGPTApi $chatGPTApi,
        private readonly ConsumptionDataFormatter $consumptionDataFormatter,
        private readonly ConsumptionDiffResolver $consumptionDiffResolver,
        private readonly EmailSender $emailSender,
        private readonly EnergyDailyConsumptionRepository $energyDailyConsumptionRepository,
        private readonly EmailTemplateBuilder $emailTemplateBuilder,
        private readonly MostConsumedConsumptionsResolver $mostConsumedConsumptionsResolver,
        private readonly MostSavedConsumptionsResolver $mostSavedConsumptionsResolver,
        private readonly UserGoalProgressResolver $userGoalProgressResolver,
        private readonly UserGoalsRepository $userGoalsRepository,
        private readonly UserGroupEnergyConsumptionRepository $userGroupEnergyConsumptionRepository,
        private readonly UserPositionByUserGroupCalculator $userPositionByUserGroupCalculator,
    ) {
    }

    public function handle(Users $user): void
    {
        $consumptions = $this->energyDailyConsumptionRepository->findUserConsumptionBetweenDates($user, (new \DateTime('1 week ago'))->setTime(0, 0), new \DateTime());
        $oldConsumptions = $this->energyDailyConsumptionRepository->findUserConsumptionBetweenDates($user, (new \DateTime('2 week ago'))->setTime(0, 0), (new \DateTime('1 week ago'))->setTime(0, 0));
        $formattedConsumptions = $this->consumptionDataFormatter->format($consumptions);
        $formattedOldConsumptions = $this->consumptionDataFormatter->format($oldConsumptions);

        $consumptions = $this->consumptionDiffResolver->resolve($formattedConsumptions, $formattedOldConsumptions);
        $mostConsumedConsumptions = $this->mostConsumedConsumptionsResolver->resolve($consumptions);
        $mostSavedConsumptions = $this->mostSavedConsumptionsResolver->resolve($consumptions);

        $userGroupConsumptions = $this->userGroupEnergyConsumptionRepository->findUserGroupConsumptions($user);
        $userGroupPosition = $this->userPositionByUserGroupCalculator->calculate($consumptions, $userGroupConsumptions);

        $userGoal = $this->userGoalsRepository->findOneBy(['user' => $user, 'status' => UserGoals::GOAL_STATUS_IN_PROGRESS]);

        if ($userGoal) {
            $userGoal = $this->userGoalProgressResolver->resolve($userGoal);
        }

        $adviceRequest = $this->adviceMessageRequestBuilder->build($user, $consumptions);
        $advices = $this->chatGPTApi->sendMessage($adviceRequest);

        $consumptionChartData = file_get_contents('public/' . $user->getId() . '_' . (new \DateTime())->format('Y-m-d') . '.png');
        $consumptionChart = 'data:image/png;base64,' . base64_encode($consumptionChartData);

        $userGroupChartData = file_get_contents('public/' . $user->getId() . '_' . (new \DateTime())->format('Y-m-d') . '_user_group.png');
        $userGroupChartChart = 'data:image/png;base64,' . base64_encode($userGroupChartData);

        $emailContent = $this->emailTemplateBuilder->build(
            $consumptions,
            $mostSavedConsumptions,
            $mostConsumedConsumptions,
            $userGroupPosition,
            $userGoal,
            $advices,
            $consumptionChart,
            $userGroupChartChart
        );

        $this->emailSender->send($user, $emailContent);
    }
}