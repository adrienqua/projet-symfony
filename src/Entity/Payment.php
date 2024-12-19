<?php

namespace App\Entity;

use App\Repository\PaymentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Payment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    private float $amount;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $paymentDate;

    #[ORM\ManyToOne(targetEntity: Contract::class, inversedBy: 'payments')]
    private Contract $contract;

    #[ORM\Column(type: 'string')]
    private string $method;
}
