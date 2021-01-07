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
     * @ORM\ManyToMany(targetEntity=Dish::class, inversedBy="orders")
     */
    private $Dish;

    /**
     * @ORM\Column(type="string", length=255, columnDefinition="ENUM('delivered', 'in delivering', 'in preparation')") )
     */
    private $state;

    /**
     * @ORM\Column(type="integer")
     */
    private $orderNumber;

    public function __construct()
    {
        $this->Dish = new ArrayCollection();
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
}
