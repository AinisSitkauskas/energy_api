<?php

declare(strict_types=1);

namespace App\Service\API;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class ChatGPTApi
{
    public function __construct(private readonly HttpClientInterface $client)
    {
    }

    public function sendMessage($message): string
    {
        $response = $this->client->request(
            'POST',
            'https://api.openai.com/v1/chat/completions',
            [
                'headers' => [
                    'Authorization' => 'Bearer ' . $_ENV['CHAP_GPT_API_KEY'],
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'model' => 'gpt-3.5-turbo',
                    'messages' => [['role' => 'user', 'content' => $message]],
                ],
            ]
        );

        $reply =  $response->toArray();

        return $reply['choices'][0]['message']['content'] ?? '';
    }
}