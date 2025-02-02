<?php

namespace App\Controller;

use App\Entity\Offer;
use App\Form\OfferType;
use App\Repository\OfferRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

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
    public function offerDetails(string $id, OfferRepository $offerRepository, Request $request): Response
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

    

        return $this->render('offer/offer_details.html.twig', [
            'offer' => $offer,
            'taskForm' => $form->createView(),
        ]);
    }
}
