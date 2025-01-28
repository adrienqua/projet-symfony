<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class OrderController extends AbstractController
{
    #[Route('/commande/succes/{session_id}', name: 'app_order_success')]
    public function orderSuccess(string $session_id): Response
    {
        return $this->render('order/success.html.twig', [
        'session_id' => $session_id
        ]);
    }

    #[Route('/commande/echec/{session_id}', name: 'app_order_failure')]
    public function orderCancel(string $session_id): Response
    {
        return $this->render('order/failure.html.twig', [
        'session_id' => $session_id
        ]);
    }
}
