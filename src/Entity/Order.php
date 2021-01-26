<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrderRepository::class)
 * @ORM\Table(name="`order`")
 */
class Order
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
    private $delivery_date;

    /**
     * @ORM\ManyToOne(targetEntity=Restaurant::class, inversedBy="orders")
     */
    private $restaurant;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="orders")
     */
    private $users;

    /**
     * @ORM\Column(type="string", length=255, columnDefinition="ENUM('delivered', 'in delivering', 'in preparation')" )
     */
    private $state;

    /**
     * @ORM\Column(type="integer")
     */
    private $orderNumber;

    /**
     * @ORM\OneToMany(targetEntity=OrderDish::class, mappedBy="orders")
     */
    private $orderDishes;

    /**
     * @ORM\OneToOne(targetEntity=Commentary::class, mappedBy="orderDishes", cascade={"persist", "remove"})
     */
    private $commentary;

    public function __construct()
    {
        $this->orderDishes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDeliveryDate(): ?\DateTimeInterface
    {
        return $this->delivery_date;
    }

    public function setDeliveryDate(\DateTimeInterface $delivery_date): self
    {
        $this->delivery_date = $delivery_date;

        return $this;
    }

    public function getRestaurant(): ?Restaurant
    {
        return $this->restaurant;
    }

    public function setRestaurant(?Restaurant $restaurant): self
    {
        $this->restaurant = $restaurant;

        return $this;
    }

    public function getUsers(): ?User
    {
        return $this->users;
    }

    public function setUsers(?User $users): self
    {
        $this->users = $users;
        return $this;
    }

    /**
     * @return Collection|Dish[]
     */
    public function getDish(): Collection
    {
        return $this->Dish;
    }

    public function addDish(Dish $dish): self
    {
        if (!$this->Dish->contains($dish)) {
            $this->Dish[] = $dish;
        }

        return $this;
    }

    public function removeDish(Dish $dish): self
    {
        $this->Dish->removeElement($dish);

        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(string $state): self
    {
        if (!in_array($state, array('delivered', 'in delivering', 'in preparation'))) {
            throw new \InvalidArgumentException("Invalid state");
        }
        $this->state = $state;
        return $this;
    }

    public function getOrderNumber(): ?int
    {
        return $this->orderNumber;
    }

    public function setOrderNumber(int $orderNumber): self
    {
        $this->orderNumber = $orderNumber;

        return $this;
    }

    /**
     * @return Collection|OrderDish[]
     */
    public function getOrderDishes(): Collection
    {
        return $this->orderDishes;
    }

    public function addOrderDish(OrderDish $orderDish): self
    {
        if (!$this->orderDishes->contains($orderDish)) {
            $this->orderDishes[] = $orderDish;
            $orderDish->setOrders($this);
        }

        return $this;
    }

    public function removeOrderDish(OrderDish $orderDish): self
    {
        if ($this->orderDishes->removeElement($orderDish)) {
            // set the owning side to null (unless already changed)
            if ($orderDish->getOrders() === $this) {
                $orderDish->setOrders(null);
            }
        }

        return $this;
    }

    public function getCommentary(): ?Commentary
    {
        return $this->commentary;
    }

    public function setCommentary(?Commentary $commentary): self
    {
        // unset the owning side of the relation if necessary
        if ($commentary === null && $this->commentary !== null) {
            $this->commentary->setOrderDishes(null);
        }

        // set the owning side of the relation if necessary
        if ($commentary !== null && $commentary->getOrderDishes() !== $this) {
            $commentary->setOrderDishes($this);
        }

        $this->commentary = $commentary;

        return $this;
    }
}
