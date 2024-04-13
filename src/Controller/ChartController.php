<?php

namespace App\Controller;

use App\Repository\UsersRepository;
use App\Service\Handler\Chart\GenerateUserEnergyConsumptionGraphHandler;
use App\Service\Handler\Chart\GenerateUserGroupGraphHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ChartController extends AbstractController
{
    #[Route('/chart/{userId}/generate-energy-consumption-graph', name: 'generate_user_energy_consumption_graph')]
    public function generateUserEnergyConsumptionGraphAction(
        GenerateUserEnergyConsumptionGraphHandler $generateUserEnergyConsumptionGraphHandler,
        int $userId,
        UsersRepository $usersRepository
    ): Response {
        $user = $usersRepository->find($userId);

        if (!$user) {
            return new Response('USER NOT FOUND', Response::HTTP_BAD_REQUEST);
        }

        $data = $generateUserEnergyConsumptionGraphHandler->handle($user);

        return $this->render('chart/consumption_chart.html.twig', [
            'data' => json_encode($data),
        ]);
    }

    #[Route('/chart/{userId}/generate-user-group-graph', name: 'generate_user_energy_consumption_graph')]
    public function generateUserGroupGraphAction(
        GenerateUserGroupGraphHandler $generateUserGroupGraphHandler,
        int $userId,
        UsersRepository $usersRepository
    ): Response {
        $user = $usersRepository->find($userId);

        if (!$user) {
            return new Response('USER NOT FOUND', Response::HTTP_BAD_REQUEST);
        }

        $data = $generateUserGroupGraphHandler->handle($user);

        return $this->render('chart/energy_group_chart.html.twig', [
            'data' => json_encode($data),
        ]);
    }

    #[Route('/chart/{userId}/save-canvas', name: 'save_canvas', methods: [
        Request::METHOD_POST
    ])]
    public function saveCanvasAction(Request $request): Response
    {
        var_dump($request->getContent());

        $data = json_decode($request->getContent(), true);

        $imageData = $data['image'];

        // Remove the prefix 'data:image/png;base64,' from the data URL if present
        if (strpos($imageData, 'base64,') !== false) {
            list(, $imageData) = explode('base64,', $imageData);
        }

        $imageData = base64_decode($imageData);
        $filePath = $data['image_name']; // Specify path where image should be saved
        file_put_contents($filePath, $imageData);

        return new Response(json_encode(['success' => true]), Response::HTTP_OK, ['Content-Type' => 'application/json']);
    }
}