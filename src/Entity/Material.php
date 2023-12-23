<?php

namespace App\Entity;

use App\Repository\MaterialRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MaterialRepository::class)]
class Material
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?float $coefficentPrice = null;

    #[ORM\OneToMany(mappedBy: 'material', targetEntity: ProductSelected::class)]
    private Collection $productSelecteds;

    public function __construct()
    {
        $this->productSelecteds = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getCoefficentPrice(): ?float
    {
        return $this->coefficentPrice;
    }

    public function setCoefficentPrice(float $coefficentPrice): static
    {
        $this->coefficentPrice = $coefficentPrice;

        return $this;
    }

    /**
     * @return Collection<int, ProductSelected>
     */
    public function getProductSelecteds(): Collection
    {
        return $this->productSelecteds;
    }

    public function addProductSelected(ProductSelected $productSelected): static
    {
        if (!$this->productSelecteds->contains($productSelected)) {
            $this->productSelecteds->add($productSelected);
            $productSelected->setMaterial($this);
        }

        return $this;
    }

    public function removeProductSelected(ProductSelected $productSelected): static
    {
        if ($this->productSelecteds->removeElement($productSelected)) {
            // set the owning side to null (unless already changed)
            if ($productSelected->getMaterial() === $this) {
                $productSelected->setMaterial(null);
            }
        }

        return $this;
    }
}
