<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Task;
use App\Entity\User;
use App\Repository\UserRepository;

final class TaskController extends AbstractController
{
    #[Route('/task', name: 'app_task')]
    public function index(): Response
    {
        return $this->render('task/index.html.twig', [
            'controller_name' => 'TaskController',
        ]);
    }

    #[Route('/task/{id}/toggle-favorite', name: 'app_task_toggle_favorite', methods: ['POST'])]
    public function toggleFavorite(
        Task $task,
        UserRepository $userRepository
    ): JsonResponse
    {
        $currentUser = $this->getUser();
        if (!$currentUser || !$currentUser instanceof User) {
            return new JsonResponse(['error' => 'User must be logged in'], 403);
        }
        
        // Maintenant on est sûr que $currentUser est bien un User
        $user = $userRepository->findCompleteUser($currentUser->getId());
        if (!$user) {
            return new JsonResponse(['error' => 'User not found'], 404);
        }

        $isFavorite = $userRepository->toggleFavoriteTask($user, $task);

        return new JsonResponse([
            'success' => true,
            'isFavorite' => $isFavorite
        ]);
    }
}
