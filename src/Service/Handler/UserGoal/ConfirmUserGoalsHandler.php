<?php

declare(strict_types=1);

namespace App\Service\Handler\UserGoal;

use App\Entity\UserGoals;
use App\Entity\Users;
use App\Repository\UserGoalsRepository;
use App\Service\Builder\UserGoal\CurrentUserGoalResponseBuilder;
use App\Service\Resolver\UserGoal\UserGoalProgressResolver;
use App\Service\SaveHandler\UserGoal\UpdateUserGoalSaveHandler;
use Doctrine\ORM\EntityManagerInterface;

class ConfirmUserGoalsHandler
{
    public function __construct(
        private readonly CurrentUserGoalResponseBuilder $currentUserGoalResponseBuilder,
        private readonly EntityManagerInterface $em,
        private readonly UpdateUserGoalSaveHandler $updateUserGoalSaveHandler,
        private readonly UserGoalProgressResolver $userGoalProgressResolver,
        private readonly UserGoalsRepository $userGoalsRepository,
    ) {
    }

    public function handle(UserGoals $userGoal, Users $user): array
    {
        $userGoal = $this->updateUserGoalSaveHandler->save($userGoal, UserGoals::GOAL_STATUS_IN_PROGRESS);

        $waitingUserGoals = $this->userGoalsRepository->findBy(['user' => $user, 'status' => UserGoals::GOAL_STATUS_WAITING]);

        foreach ($waitingUserGoals as $waitingUserGoal) {
            $this->em->remove($waitingUserGoal);
        }

        $this->em->flush();

        $userGoal = $this->userGoalProgressResolver->resolve($userGoal);

        return $this->currentUserGoalResponseBuilder->build($userGoal);
    }
}