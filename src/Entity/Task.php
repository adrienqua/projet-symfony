<?php

namespace App\Entity;

use App\Repository\TaskRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Task
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 255)]
    private string $title;

    #[ORM\Column(type: 'text')]
    private string $description;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    private float $proposedPrice;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $requestDate;

    #[ORM\Column(type: 'boolean')]
    private bool $isAdultContent;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'tasks')]
    private User $requester;

    #[ORM\ManyToMany(targetEntity: Offer::class, inversedBy: 'tasks')]
    private $offers;
}
