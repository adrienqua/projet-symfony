<?php 

namespace App\Enum;

enum OrderStatusEnum: string
{
    case PENDING = 'En attente de paiement';
    case PAID = 'Payée';
    case REJECTED = 'Rejetée';

    public function color(): string
    {
        return match($this) {
            self::PENDING => 'yellow',
            self::PAID => 'green',
            self::REJECTED => 'red',
        };
    }
}
