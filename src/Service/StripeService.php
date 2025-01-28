<?php

namespace App\Service;

use Stripe\StripeClient;

class StripeService
{
    private StripeClient $stripeClient;

    public function __construct(string $secretKey)
    {
        $this->stripeClient = new StripeClient($secretKey);
    }

    public function createPaymentIntent(int $amount, string $currency = 'usd'): array
    {
        return $this->stripeClient->paymentIntents->create([
            'amount' => $amount,
            'currency' => $currency,
        ])->toArray();
    }

}
