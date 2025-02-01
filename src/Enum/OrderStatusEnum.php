<?php 

namespace App\Enum;

enum OrderStatusEnum: string
{
    case PENDING = 'En attente de paiement';
    case PAID = 'Payée';
    case REJECTED = 'Rejetée';
}