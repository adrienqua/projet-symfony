<?php

namespace App\Entity;

use App\Repository\ContractRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContractRepository::class)]
class Contract
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string')]
    private string $status;

    #[ORM\Column(type: 'datetime_immutable')]
    private \DateTimeImmutable $createdAt;

    #[ORM\ManyToOne(targetEntity: Task::class)]
    private Task $task;

    #[ORM\OneToMany(mappedBy: 'contract', targetEntity: Message::class)]
    private $messages;

    #[ORM\OneToMany(mappedBy: 'contract', targetEntity: Payment::class)]
    private $payments;

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

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
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
}
