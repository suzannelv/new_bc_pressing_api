<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ProductSelectedRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductSelectedRepository::class)]
#[ApiResource]
class ProductSelected
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'productSelecteds')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Product $product = null;


    #[ORM\ManyToOne(inversedBy: 'productSelecteds')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Material $material = null;

    #[ORM\Column]
    private ?float $totalPrice = null;

    #[ORM\ManyToMany(targetEntity: ServiceOption::class, inversedBy: 'product')]
    private Collection $serviceOptions;

    #[ORM\ManyToOne(inversedBy: 'productSelected')]
    #[ORM\JoinColumn(nullable: false)]
    private ?OrderDetail $orderDetail = null;

    public function __construct()
    {
        $this->serviceOptions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): static
    {
        $this->product = $product;

        return $this;
    }


    public function getMaterial(): ?Material
    {
        return $this->material;
    }

    public function setMaterial(?Material $material): static
    {
        $this->material = $material;

        return $this;
    }

    public function getTotalPrice(): ?float
    {
        return $this->totalPrice;
    }

    public function setTotalPrice(float $totalPrice): static
    {
        $this->totalPrice = $totalPrice;

        return $this;
    }

    /**
     * @return Collection<int, ServiceOption>
     */
    public function getServiceOptions(): Collection
    {
        return $this->serviceOptions;
    }

    public function addServiceOption(ServiceOption $serviceOption): static
    {
        if (!$this->serviceOptions->contains($serviceOption)) {
            $this->serviceOptions->add($serviceOption);
            $serviceOption->addProduct($this);
        }

        return $this;
    }

    public function removeServiceOption(ServiceOption $serviceOption): static
    {
        if ($this->serviceOptions->removeElement($serviceOption)) {
            $serviceOption->removeProduct($this);
        }

        return $this;
    }

    public function getOrderDetail(): ?OrderDetail
    {
        return $this->orderDetail;
    }

    public function setOrderDetail(?OrderDetail $orderDetail): static
    {
        $this->orderDetail = $orderDetail;

        return $this;
    }
}
