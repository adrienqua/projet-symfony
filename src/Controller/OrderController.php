<?php

namespace App\Controller;

use App\Entity\Payment;
use App\Enum\OrderStatusEnum;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class OrderController extends AbstractController
{
    #[Route('/commande/succes/{session_id}', name: 'app_order_success')]
    public function orderSuccess(string $session_id, EntityManagerInterface $entityManager): Response
    {

        $payment = $entityManager->getRepository(Payment::class)->findOneBy(['stripeSessionId' => $session_id]);
        $payment->getOrder()->setStatus(OrderStatusEnum::PAID);

        $entityManager->persist($payment);
        $entityManager->flush();

        return $this->render('order/success.html.twig', [
        'session_id' => $session_id
        ]);
    }

    #[Route('/commande/echec/{session_id}', name: 'app_order_failure')]
    public function orderCancel(string $session_id, EntityManagerInterface $entityManager): Response
    {
        $payment = $entityManager->getRepository(Payment::class)->findOneBy(['stripeSessionId' => $session_id]);
        $payment->getOrder()->setStatus(OrderStatusEnum::REJECTED);

        $entityManager->persist($payment);
        $entityManager->flush();

        return $this->render('order/failure.html.twig', [
        'session_id' => $session_id
        ]);
    }
}
