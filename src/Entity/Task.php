<?php

namespace App\Entity;

use App\Repository\TaskRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TaskRepository::class)]
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

    #[ORM\Column(type: 'datetime_immutable')]
    private \DateTimeImmutable $createdAt;

    #[ORM\Column(type: 'boolean')]
    private bool $isAdultContent;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'tasks')]
    private User $requester;

    #[ORM\ManyToMany(targetEntity: Offer::class, inversedBy: 'tasks')]
    private Collection $offers;

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;
        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;
        return $this;
    }

    public function getProposedPrice(): float
    {
        return $this->proposedPrice;
    }

    public function setProposedPrice(float $proposedPrice): static
    {
        $this->proposedPrice = $proposedPrice;
        return $this;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getIsAdultContent(): bool
    {
        return $this->isAdultContent;
    }

    public function setIsAdultContent(bool $isAdultContent): static
    {
        $this->isAdultContent = $isAdultContent;
        return $this;
    }

    public function getRequester(): User
    {
        return $this->requester;
    }

    public function setRequester(User $requester): static
    {
        $this->requester = $requester;
        return $this;
    }

    public function getOffers()
    {
        return $this->offers;
    }

    public function addOffer(Offer $offer): static
    {
        if (!$this->offers->contains($offer)) {
            $this->offers[] = $offer;
        }
        return $this;
    }

    public function removeOffer(Offer $offer): static
    {
        $this->offers->removeElement($offer);
        return $this;
    }
}
