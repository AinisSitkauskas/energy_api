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
use App\Service\Formatter\Feedback\ConsumptionDataFormatter;
use App\Service\Resolver\Feedback\ConsumptionDiffResolver;
use App\Service\Resolver\Feedback\MostConsumedConsumptionsResolver;
use App\Service\Resolver\Feedback\MostSavedConsumptionsResolver;

class SendUserFeedbackHandler
{
    public function __construct(
        private readonly AdviceMessageRequestBuilder $adviceMessageRequestBuilder,
        private readonly ChatGPTApi $chatGPTApi,
        private readonly ConsumptionDataFormatter $consumptionDataFormatter,
        private readonly ConsumptionDiffResolver $consumptionDiffResolver,
        private readonly EnergyDailyConsumptionRepository $energyDailyConsumptionRepository,
        private readonly MostConsumedConsumptionsResolver $mostConsumedConsumptionsResolver,
        private readonly MostSavedConsumptionsResolver $mostSavedConsumptionsResolver,
        private readonly UserGoalsRepository $userGoalsRepository,
        private readonly UserGroupEnergyConsumptionRepository $userGroupEnergyConsumptionRepository,
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

        // TODO: Graph for user consumption
        // TODO: Graph for users group consumption

        $userGoal = $this->userGoalsRepository->findOneBy(['user' => $user, 'status' => UserGoals::GOAL_STATUS_IN_PROGRESS]);

        // TODO: Advices to call API for advices
        $adviceRequest = $this->adviceMessageRequestBuilder->build($user, $consumptions, $mostConsumedConsumptions, $mostSavedConsumptions);
        $advices = $this->chatGPTApi->sendMessage($adviceRequest);

        // TODO: Html template build
        // TODO: Email sending
    }
}