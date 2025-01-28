<?php

namespace App\Controller;

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
    public function createPaymentIntent(EntityManagerInterface $entityManager): Response
    {

  //      $order = $entityManager->getRepository(Order::class)->findOneByReference(['reference' =>  $reference]);

        Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']);
        
        $DOMAIN= $_ENV['APP_DOMAIN'];


        $stripe_cart = [];
            $stripe_cart[0] = [ 
                'price_data' => [
                    'currency' => 'eur',
                    'unit_amount' => 50*100,
                    'product_data' => [
                        'name' => "test",
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
            'customer_email' => "666adrien@gmail.com",
            'line_items' => [
                $stripe_cart
            ],
            'mode' => 'payment',
            'success_url' => $DOMAIN. '/commande/succes/{CHECKOUT_SESSION_ID}',
            'cancel_url' => $DOMAIN. '/commande/echec/{CHECKOUT_SESSION_ID}',
        ]);

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
