<?php

namespace App\Controller;

use App\Entity\Offer;
use App\Entity\Order;
use App\Entity\Payment;
use App\Entity\Task;
use App\Enum\OrderStatusEnum;
use App\Service\StripeService;
use Doctrine\ORM\EntityManagerInterface;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PaymentController extends AbstractController
{
    private StripeService $stripeService;

    public function __construct(StripeService $stripeService)
    {
        $this->stripeService = $stripeService;
    }

    #[Route('/paiement', name: 'app_stripe')]
    public function createPaymentIntent(EntityManagerInterface $entityManager, Request $request): Response
    {
        $user = $this->getUser();

        $taskId = $request->query->get('task');
        $offerId = $request->query->get('offer');

        $selectedTask = $entityManager->getRepository(Task::class)->find($taskId);
        $offer = $entityManager->getRepository(Offer::class)->find($offerId);

        if (!$selectedTask) {
            throw $this->createNotFoundException('Task not found');
        }

        Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']);
        
        $DOMAIN= $_ENV['APP_DOMAIN'];

        $stripe_cart = [];
            $stripe_cart[0] = [ 
                'price_data' => [
                    'currency' => 'eur',
                    'unit_amount' => $selectedTask->getPrice() * 100,
                    'product_data' => [
                        'name' => $selectedTask->getTitle(),
                    ],
                ],
                'quantity' => 1,
            ];

        $stripe_cart[]  = [
            'price_data' => [
                'currency' => 'eur',
                'unit_amount' => 1.69*100,
                'product_data' => [
                    'name' => 'Frais de service',
                ],
            ],
            'quantity' => 1,
        ];  
  


        $checkout_session = Session::create([
            'customer_email' => $user->getEmail(),
            'line_items' => [
                $stripe_cart
            ],
            'mode' => 'payment',
            'success_url' => $DOMAIN. '/commande/succes/{CHECKOUT_SESSION_ID}',
            'cancel_url' => $DOMAIN. '/commande/echec/{CHECKOUT_SESSION_ID}',
        ]);





        $order = new Order();
        $order->setTask($selectedTask);
        $order->setUser($user);
        $order->setStatus(OrderStatusEnum::PENDING);
        $order->setOffer($offer);
        $entityManager->persist($order);

        $payment = new Payment();
        $payment->setAmount($selectedTask->getPrice());
        $payment->setMethod('VISA');
        $payment->setStripeSessionId($checkout_session->id);
        $payment->setOrder($order);
        $entityManager->persist($payment);
        

        //$order->setStripeSessionId($checkout_session->id);
        $entityManager->flush();
        
        
        return $this->redirect($checkout_session->url);

    }
/*     #[Route('/paiement', name: 'app_stripe')]
    public function createPaymentIntent(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $amount = $data['amount'] ?? 5000;

        if ($amount <= 0) {
            return new JsonResponse(['error' => 'Invalid amount'], 400);
        }

        $paymentIntent = $this->stripeService->createPaymentIntent($amount);

        return new JsonResponse($paymentIntent);
    } */
}
