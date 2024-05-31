<?php

declare(strict_types=1);

namespace App\Command;

use App\Entity\UserGoals;
use App\Repository\UserGoalsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:clear-user-goals')]
class ClearNotSelectedUserGoalsCommand extends Command
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly UserGoalsRepository $userGoalsRepository,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $userGoals = $this->userGoalsRepository->findBy(['status' => UserGoals::GOAL_STATUS_WAITING]);

        foreach ($userGoals as $userGoal) {
            $this->em->remove($userGoal);
        }

        $this->em->flush();

        return Command::SUCCESS;
    }
}