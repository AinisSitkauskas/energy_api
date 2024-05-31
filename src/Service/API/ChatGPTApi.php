<?php

declare(strict_types=1);

namespace App\Service\API;

use OpenAI;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ChatGPTApi
{
    public const STATUS_COMPLETED = 'completed';

    public function __construct(private readonly HttpClientInterface $client)
    {
    }

    public function sendMessage($message): string
    {
        $client = OpenAI::client($_ENV['CHAP_GPT_API_KEY']);

        $result = $client->threads()->createAndRun(
            [
                'assistant_id' => $_ENV['CHAP_GPT_API_ASSISTANT_ID'],
                'thread' => [
                    'messages' =>
                        [
                            [
                                'role' => 'user',
                                'content' => $message,
                            ],
                        ],
                ],
            ],
        );

        $timeLimit = new \Datetime('+30 seconds');

        while ((new \DateTime()) < $timeLimit) {
            $runCheck = $client->threads()->runs()->retrieve(
                threadId: $result->threadId,
                runId: $result->id,
            );

            if ($runCheck->status === self::STATUS_COMPLETED) {
                break;
            }

            sleep(1);
        }

        $response = $client->threads()->messages()->list($result->threadId, [
            'limit' => 2,
        ]);

        return $response->data[0]->content[0]->text['value'] ?? '';
    }
}