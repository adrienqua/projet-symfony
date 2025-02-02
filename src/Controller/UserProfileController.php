<?php

namespace App\Controller;

use App\Entity\Conversation;
use App\Entity\Message;
use App\Entity\User;
use App\Form\AddMessageType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\UserProfileType;
use App\Form\UserType;
use App\Repository\ConversationRepository;
use Doctrine\ORM\EntityManagerInterface;

final class UserProfileController extends AbstractController
{
    #[Route('/profil', name: 'app_user_profile')]
    public function profile(Request $request, EntityManagerInterface $entityManager): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        $form = $this->createForm(UserProfileType::class, $user);
        $form->handleRequest($request);

        $orders = $user->getOrders();

        if (!$user) {
            return $this->redirectToRoute('app_login');
        }


        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'Votre profil a été mis à jour avec succès.');

            return $this->redirectToRoute('app_user_profile');
        }

        return $this->render('user_profile/index.html.twig', [
            'form' => $form->createView(),
            'orders' => $orders,
        ]);
    }

    #[Route('/profil/message/{username}', name: 'app_user_profile_message')]
    public function profileMessage(string $username, Request $request, EntityManagerInterface $entityManager, ConversationRepository $conversationRepository): Response
    {
        $recipient = $entityManager->getRepository(User::class)->findOneBy(['username' => $username]);
        $user = $this->getUser();

        if (!$user || !$recipient) {
            return $this->redirectToRoute('app_login');
        }

        $conversation = $conversationRepository->findOneByUsers([$user, $recipient]);

        if (!$conversation) {
            $conversation = new Conversation();
            $conversation->addUser($user);
            $conversation->addUser($recipient);
            $entityManager->persist($conversation);
            $entityManager->flush();
        }

        $message = new Message();
        $message->setSender($user);
        $message->setRecipient($recipient);
        $message->setConversation($conversation);

        $form = $this->createForm(AddMessageType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($message);
            $entityManager->flush();

            return $this->redirectToRoute('app_user_profile_message', ['username' => $username]);
        }


        return $this->render('user_profile/messages.html.twig', [
            'form' => $form,
            'recipient' => $recipient,
            'conversation' => $conversation,
        ]);
    }
}
