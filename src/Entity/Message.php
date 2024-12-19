<?php

namespace App\Entity;

use App\Repository\MessageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Message
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'text')]
    private string $content;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $sentDate;

    #[ORM\ManyToOne(targetEntity: User::class)]
    private User $sender;

    #[ORM\ManyToOne(targetEntity: User::class)]
    private User $recipient;

    #[ORM\ManyToOne(targetEntity: Contract::class, inversedBy: 'messages')]
    private ?Contract $contract;
}
