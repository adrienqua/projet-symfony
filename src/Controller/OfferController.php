<?php

namespace App\Controller;

use App\Entity\Offer;
use App\Entity\Review;
use App\Entity\User;
use App\Form\AddReviewType;
use App\Form\OfferType;
use App\Repository\OfferRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class OfferController extends AbstractController
{   
    #[Route('/annonces', name: 'app_offers_list')]
    public function offerList(OfferRepository $offerRepository): Response
    {
        $offers = $offerRepository->findAll();


        return $this->render('offer/offer_list.html.twig', [
            'offers' => $offers,
        ]);
    }

    #[Route('/annonces/{id}', name: 'app_offer_details', methods: ['GET', 'POST'])]
    public function offerDetails(string $id, OfferRepository $offerRepository, Request $request, EntityManagerInterface $em): Response
    {
        $offer = $offerRepository->find($id);

        $user = $this->getUser();

        $form = $this->createFormBuilder()
            ->add('tasks', ChoiceType::class, [
                'choices' => $offer->getTasks(),
                'attr' => ['class' => 'form-input mt-1 block w-full rounded-lg p-2 mb-4 bg-gray-100 dark:bg-gray-800'],
                'label' => 'Activités proposées',
                'label_attr' => ['class' => 'block  font-medium mb-2'],
                'choice_label' => function($task) {
                    return $task->getTitle() . ' - ' . $task->getPrice() . ' €';
                },
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Acheter ce service',
                'attr' => ['class' => 'mt-2 py-2 px-4 border transition-all duration-300 border-fuchsia-400 text-fuchsia-400 hover:text-gray-800 font-medium rounded-xl hover:bg-fuchsia-300 focus:ring-2 focus:ring-fuchsia-200 focus:ring-offset-2 dark:border-fuchsia-200 dark:text-fuchsia-200 dark:hover:bg-fuchsia-300 dark:focus:ring-fuchsia-100 dark:hover:text-gray-800']
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $selectedTask = $form->get('tasks')->getData();
            if ($user) {
                return $this->redirectToRoute('app_stripe', ['task' => $selectedTask->getId(),'offer' => $offer->getId()]);
            } else {
                return $this->redirectToRoute('app_login');
            }
        }

        $review = new Review();
        $reviewForm = $this->createForm(AddReviewType::class, $review);
        $reviewForm->handleRequest($request);

        if ($reviewForm->isSubmitted() && $reviewForm->isValid()) {
            $review->setOffer($offer);
            $review->setRating($reviewForm->get('rating')->getData());
            $review->setAuthor($this->getUser());
            $em->persist($review);
            $em->flush();

            return $this->redirectToRoute('app_offer_details', ['id' => $id]);
        }
    

        return $this->render('offer/offer_details.html.twig', [
            'offer' => $offer,
            'taskForm' => $form->createView(),
            'reviewForm' => $reviewForm->createView(),
            'review' => $review
        ]);
    }

    #[Route('/annonces/{id}/favorite', name: 'app_offer_toggle_favorite', methods: ['POST'])]
    public function toggleFavorite(
        Offer $task,
        UserRepository $userRepository
    ): JsonResponse
    {
        $currentUser = $this->getUser();
        if (!$currentUser || !$currentUser instanceof User) {
            return new JsonResponse(['error' => 'User must be logged in'], 403);
        }
        
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
