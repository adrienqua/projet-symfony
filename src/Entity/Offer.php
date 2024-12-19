<?php

namespace App\Entity;

use App\Repository\OfferRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Offer
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
    private float $price;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $creationDate;

    #[ORM\Column(type: 'boolean')]
    private bool $isAdultContent;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'offers')]
    private User $proposer;

    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'offers')]
    private Category $category;

    #[ORM\ManyToMany(targetEntity: Task::class, mappedBy: 'offers')]
    private $tasks;
}
