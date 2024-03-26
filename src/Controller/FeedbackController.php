<?php

declare(strict_types = 1);

namespace App\Controller;

use App\Service\Handler\Feedback\SendUserFeedbackHandler;
use App\Service\Validator\Feedback\SendUserFeedbackValidator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\UsersRepository;

class FeedbackController extends AbstractController
{
    #[Route('/feedback/send-user', name: 'send_user_feedback', methods: [
        Request::METHOD_POST
    ])]
    public function sendUserFeedbackAction(
        Request $request,
        SendUserFeedbackHandler $sendUserFeedbackHandler,
        SendUserFeedbackValidator $sendUserFeedbackValidator,
        UsersRepository $usersRepository
    ): Response {
        $data = json_decode($request->getContent(), true);

        if (!$sendUserFeedbackValidator->validate($data)) {
            return new Response('BAD REQUEST', Response::HTTP_BAD_REQUEST);
        }

        $user = $usersRepository->find($data['user_id']);

        if (!$user) {
            return new Response('USER NOT FOUND', Response::HTTP_BAD_REQUEST);
        }

        try {
            $sendUserFeedbackHandler->handle($user);
            return new Response('SUCCESS!', Response::HTTP_OK);

        } catch (\Exception $e) {
            return new Response('ERROR: ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
