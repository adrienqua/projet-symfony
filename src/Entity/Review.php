<?php

namespace App\Entity;

use App\Repository\ReviewRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Review
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'integer')]
    private int $rating;

    #[ORM\Column(type: 'text')]
    private string $comment;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $reviewDate;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'reviews')]
    private User $reviewedUser;

    #[ORM\ManyToOne(targetEntity: Offer::class)]
    private Offer $offer;
}
