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

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getProposedPrice(): float
    {
        return $this->proposedPrice;
    }

    public function setProposedPrice(float $proposedPrice): self
    {
        $this->proposedPrice = $proposedPrice;
        return $this;
    }

    public function getRequestDate(): \DateTimeInterface
    {
        return $this->requestDate;
    }

    public function setRequestDate(\DateTimeInterface $requestDate): self
    {
        $this->requestDate = $requestDate;
        return $this;
    }

    public function getIsAdultContent(): bool
    {
        return $this->isAdultContent;
    }

    public function setIsAdultContent(bool $isAdultContent): self
    {
        $this->isAdultContent = $isAdultContent;
        return $this;
    }

    public function getRequester(): User
    {
        return $this->requester;
    }

    public function setRequester(User $requester): self
    {
        $this->requester = $requester;
        return $this;
    }

    public function getOffers()
    {
        return $this->offers;
    }

    public function addOffer(Offer $offer): self
    {
        if (!$this->offers->contains($offer)) {
            $this->offers[] = $offer;
        }
        return $this;
    }

    public function removeOffer(Offer $offer): self
    {
        $this->offers->removeElement($offer);
        return $this;
    }
}
