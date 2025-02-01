<?php

namespace App\Entity;

use App\Enum\OrderStatusEnum;
use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(enumType: OrderStatusEnum::class, options: ["default" => OrderStatusEnum::PENDING])]
    private OrderStatusEnum $status;

    #[ORM\Column(type: 'datetime_immutable')]
    private \DateTimeImmutable $createdAt;

    #[ORM\ManyToOne(targetEntity: Task::class)]
    private Task $task;

    #[ORM\OneToMany(mappedBy: 'order', targetEntity: Message::class)]
    private $messages;

    #[ORM\OneToMany(mappedBy: 'order', targetEntity: Payment::class, cascade: ['persist'])]
    private $payments;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    private ?Offer $offer = null;

    public function __construct()
    {
        $this->setCreatedAt(new \DateTimeImmutable());
        $this->messages = new ArrayCollection();
        $this->payments = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getStatus(): OrderStatusEnum
    {
        return $this->status;
    }

    public function setStatus(OrderStatusEnum $status): static
    {
        $this->status = $status;
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

    public function getTask(): Task
    {
        return $this->task;
    }

    public function setTask(Task $task): static
    {
        $this->task = $task;
        return $this;
    }

    public function getMessages()
    {
        return $this->messages;
    }

    public function addMessage(Message $message): static
    {
        $this->messages[] = $message;
        return $this;
    }

    public function removeMessage(Message $message): static
    {
        $this->messages->removeElement($message);
        return $this;
    }

    public function getPayments()
    {
        return $this->payments;
    }

    public function addPayment(Payment $payment): static
    {
        $this->payments[] = $payment;
        return $this;
    }

    public function removePayment(Payment $payment): static
    {
        $this->payments->removeElement($payment);
        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getOffer(): ?Offer
    {
        return $this->offer;
    }

    public function setOffer(?Offer $offer): static
    {
        $this->offer = $offer;

        return $this;
    }
}
