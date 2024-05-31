<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\UserGoalsRepository;
use App\Repository\UsersRepository;
use App\Service\Handler\UserGoal\ConfirmUserGoalsHandler;
use App\Service\Handler\UserGoal\GenerateUserGoalsHandler;
use App\Service\Handler\UserGoal\GetUserGoalsHandler;
use App\Service\Validator\User\UserRequestValidator;
use App\Service\Validator\UserGoal\UserGoalConfirmValidator;
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
        UsersRepository $usersRepository,
    ): Response {
        $data = json_decode($request->getContent(), true);

        if (!$userRequestValidator->validate($data)) {
            return new Response('BAD REQUEST', Response::HTTP_BAD_REQUEST);
        }

        $user = $usersRepository->find($data['user_id']);

        if (!$user) {
            return new Response('USER NOT FOUND', Response::HTTP_NOT_FOUND);
        }

        try {
            $result = $generateUserGoalsHandler->handle($user);
            return new Response(json_encode($result), Response::HTTP_OK);

        } catch (\Exception $e) {
            return new Response('ERROR: ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/user-goals/confirm', name: 'confirm_user_goals', methods: [
        Request::METHOD_POST
    ])]
    public function confirmUserGoalsAction(
        Request $request,
        ConfirmUserGoalsHandler $confirmUserGoalsHandler,
        UserGoalConfirmValidator $userGoalConfirmValidator,
        UserGoalsRepository $usersGoalRepository,
        UserRequestValidator $userRequestValidator,
        UsersRepository $usersRepository,
    ): Response {
        $data = json_decode($request->getContent(), true);

        if (!$userRequestValidator->validate($data) || !$userGoalConfirmValidator->validate($data)) {
            return new Response('BAD REQUEST', Response::HTTP_BAD_REQUEST);
        }

        $user = $usersRepository->find($data['user_id']);

        if (!$user) {
            return new Response('USER NOT FOUND', Response::HTTP_NOT_FOUND);
        }

        $userGoal = $usersGoalRepository->findOneBy(['user' => $user, 'percentage' => $data['percentage']]);

        if (!$userGoal) {
            return new Response('USER GOAL NOT FOUND', Response::HTTP_NOT_FOUND);
        }

        try {
            $result = $confirmUserGoalsHandler->handle($userGoal, $user);
            return new Response(json_encode($result), Response::HTTP_OK);

        } catch (\Exception $e) {
            return new Response('ERROR: ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/user-goals/{userId}', name: 'get_user_goals', methods: [
        Request::METHOD_GET
    ])]
    public function getUserGoalsAction(
        int $userId,
        GetUserGoalsHandler $getUserGoalsHandler,
        UsersRepository $usersRepository,
    ): Response {
        $user = $usersRepository->find($userId);

        if (!$user) {
            return new Response('USER NOT FOUND', Response::HTTP_NOT_FOUND);
        }

        try {
            $result = $getUserGoalsHandler->handle($user);
            return new Response(json_encode($result), Response::HTTP_OK);

        } catch (\Exception $e) {
            return new Response('ERROR: ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}