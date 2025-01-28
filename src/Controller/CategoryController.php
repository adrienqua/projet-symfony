<?php 

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CategoryController extends AbstractController
{
    #[Route('/services', name: 'app_categories_list')]
    public function index(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();

        return $this->render('category/category_list.html.twig', [
            'categories' => $categories,
        ]);
    }

    #[Route('/services/{id}', name: 'app_category_details')]
    public function details(string $id, TaskRepository $taskRepository): Response
    {
        $task = $taskRepository->findOneBy(['id' => $id]);

        return $this->render('category/category_details.html.twig', [
            'task' => $task,
        ]);
    }
}
