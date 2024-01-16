<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\OrderStatusRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: OrderStatusRepository::class)]
#[ApiResource]
class OrderStatus
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["order:read"])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(["order:read"])]
    private ?string $status = null;

    #[ORM\OneToMany(mappedBy: 'orderStatus', targetEntity: OrderDetail::class)]
    private Collection $orderDetails;

    public function __construct()
    {
        $this->orderDetails = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection<int, OrderDetail>
     */
    public function getOrderDetails(): Collection
    {
        return $this->orderDetails;
    }

    public function addOrderDetail(OrderDetail $orderDetail): static
    {
        if (!$this->orderDetails->contains($orderDetail)) {
            $this->orderDetails->add($orderDetail);
            $orderDetail->setOrderStatus($this);
        }

        return $this;
    }

    public function removeOrderDetail(OrderDetail $orderDetail): static
    {
        if ($this->orderDetails->removeElement($orderDetail)) {
            // set the owning side to null (unless already changed)
            if ($orderDetail->getOrderStatus() === $this) {
                $orderDetail->setOrderStatus(null);
            }
        }

        return $this;
    }
}
