<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\EmployeeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: EmployeeRepository::class)]
#[ApiResource]
class Employee extends User
{

    #[ORM\Column(length: 255)]
    #[Groups(["order:read"])]
    private ?string $empNumber = null;

    #[ORM\Column]
    #[Groups(["order:read"])]
    private ?bool $adminRole = null;

    #[ORM\OneToMany(mappedBy: 'emp', targetEntity: OrderDetail::class)]
    private Collection $orderDetails;

    public function __construct()
    {
        $this->orderDetails = new ArrayCollection();
    }

    public function getEmpNumber(): ?string
    {
        return $this->empNumber;
    }

    public function setEmpNumber(string $empNumber): static
    {
        $this->empNumber = $empNumber;

        return $this;
    }

    public function isAdminRole(): ?bool
    {
        return $this->adminRole;
    }

    public function setAdminRole(bool $adminRole): static
    {
        $this->adminRole = $adminRole;

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
            $orderDetail->setEmp($this);
        }

        return $this;
    }

    public function removeOrderDetail(OrderDetail $orderDetail): static
    {
        if ($this->orderDetails->removeElement($orderDetail)) {
            // set the owning side to null (unless already changed)
            if ($orderDetail->getEmp() === $this) {
                $orderDetail->setEmp(null);
            }
        }

        return $this;
    }

    public function __toString(){
        return $this->empNumber;
    }
}
