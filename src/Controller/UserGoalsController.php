<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\UsersRepository;
use App\Service\Handler\UserGoal\GenerateUserGoalsHandler;
use App\Service\Validator\User\UserRequestValidator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UserGoalsController extends AbstractController
{
    #[Route('/user-goals/generate', name: 'generate_user_goals', methods: [
        Request::METHOD_POST
    ])]
    public function generateUserGoalsAction(
        Request $request,
        GenerateUserGoalsHandler $generateUserGoalsHandler,
        UserRequestValidator $userRequestValidator,
        UsersRepository $usersRepository
    ): Response {
        $data = json_decode($request->getContent(), true);

        if (!$userRequestValidator->validate($data)) {
            return new Response('BAD REQUEST', Response::HTTP_BAD_REQUEST);
        }

        $user = $usersRepository->find($data['user_id']);

        if (!$user) {
            return new Response('USER NOT FOUND', Response::HTTP_BAD_REQUEST);
        }

        try {
            $result = $generateUserGoalsHandler->handle($user);
            return new Response(json_encode($result), Response::HTTP_OK);

        } catch (\Exception $e) {
            return new Response('ERROR: ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}