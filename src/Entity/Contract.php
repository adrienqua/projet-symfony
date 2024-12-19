<?php

namespace App\Entity;

use App\Repository\ContractRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Contract
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string')]
    private string $status;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $creationDate;

    #[ORM\ManyToOne(targetEntity: Task::class)]
    private Task $task;

    #[ORM\OneToMany(mappedBy: 'contract', targetEntity: Message::class)]
    private $messages;

    #[ORM\OneToMany(mappedBy: 'contract', targetEntity: Payment::class)]
    private $payments;
}
