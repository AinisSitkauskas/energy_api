<?php

declare(strict_types=1);

namespace App\Command;

use App\Entity\UserGoals;
use App\Repository\UserGoalsRepository;
use App\Service\Handler\UserGoal\UpdateUserGoalsHandler;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:update-user-goals')]
class UpdateUserGoalsCommand extends Command
{
    public function __construct(
        private readonly UserGoalsRepository $userGoalsRepository,
        private readonly UpdateUserGoalsHandler $updateUserGoalsHandler,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $userGoals = $this->userGoalsRepository->findBy(['status' => UserGoals::GOAL_STATUS_IN_PROGRESS]);

        foreach ($userGoals as $userGoal) {
            $this->updateUserGoalsHandler->handle($userGoal);
        }

        return Command::SUCCESS;
    }
}