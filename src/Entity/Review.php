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

    public function getId(): int
    {
        return $this->id;
    }

    public function getRating(): int
    {
        return $this->rating;
    }

    public function setRating(int $rating): self
    {
        $this->rating = $rating;
        return $this;
    }

    public function getComment(): string
    {
        return $this->comment;
    }

    public function setComment(string $comment): self
    {
        $this->comment = $comment;
        return $this;
    }

    public function getReviewDate(): \DateTimeInterface
    {
        return $this->reviewDate;
    }

    public function setReviewDate(\DateTimeInterface $reviewDate): self
    {
        $this->reviewDate = $reviewDate;
        return $this;
    }

    public function getReviewedUser(): User
    {
        return $this->reviewedUser;
    }

    public function setReviewedUser(User $reviewedUser): self
    {
        $this->reviewedUser = $reviewedUser;
        return $this;
    }

    public function getOffer(): Offer
    {
        return $this->offer;
    }

    public function setOffer(Offer $offer): self
    {
        $this->offer = $offer;
        return $this;
    }
}