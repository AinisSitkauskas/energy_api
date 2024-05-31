<?php

declare(strict_types=1);

namespace App\Command;

use App\Repository\UsersRepository;
use App\Service\Handler\Feedback\SendUserFeedbackHandler;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:send-user-feedback')]
class SendUserFeedbackCommand extends Command
{
    public function __construct(
        private readonly SendUserFeedbackHandler $sendUserFeedbackHandler,
        private readonly UsersRepository $usersRepository,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $users = $this->usersRepository->findBy(['hasFeedbackReport' => true]);

        foreach ($users as $user) {
            $this->sendUserFeedbackHandler->handle($user);
        }

        return Command::SUCCESS;
    }
}