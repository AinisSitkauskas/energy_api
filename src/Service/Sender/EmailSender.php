<?php

declare(strict_types=1);

namespace App\Service\Sender;

use App\Entity\Users;
use Psr\Log\LoggerInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class EmailSender
{
    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly MailerInterface $mailer,
    ) {
    }

    public function send(Users $user, string $emailContent): void
    {
        $email = (new Email())
            ->from($_ENV['EMAIL'])
            ->to($user->getEmail())
            ->subject('Energy consumption feedback')
            ->html($emailContent);

        try {
            $this->mailer->send($email);
        } catch (\Exception $exception) {
            $this->logger->error($exception->getMessage());
        }
    }
}