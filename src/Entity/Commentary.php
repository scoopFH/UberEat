<?php

namespace App\Entity;

use App\Repository\CommentaryRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommentaryRepository::class)
 */
class Commentary
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $sendDate;

    /**
     * @ORM\Column(type="text")
     */
    private $message;

    /**
     * @ORM\OneToOne(targetEntity=Order::class, inversedBy="commentary", cascade={"persist", "remove"})
     */
    private $orderDishes;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSendDate(): ?\DateTimeInterface
    {
        return $this->sendDate;
    }

    public function setSendDate(\DateTimeInterface $sendDate): self
    {
        $this->sendDate = $sendDate;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getOrderDishes(): ?Order
    {
        return $this->orderDishes;
    }

    public function setOrderDishes(?Order $orderDishes): self
    {
        $this->orderDishes = $orderDishes;

        return $this;
    }
}
