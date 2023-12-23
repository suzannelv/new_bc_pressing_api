<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ApiResource]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    private ?Category $category = null;

    #[ORM\Column]
    private ?float $price = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'product')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ProductStatus $productStatus = null;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: ProductSelected::class)]
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

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getProductStatus(): ?ProductStatus
    {
        return $this->productStatus;
    }

    public function setProductStatus(?ProductStatus $productStatus): static
    {
        $this->productStatus = $productStatus;

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
            $productSelected->setProduct($this);
        }

        return $this;
    }

    public function removeProductSelected(ProductSelected $productSelected): static
    {
        if ($this->productSelecteds->removeElement($productSelected)) {
            // set the owning side to null (unless already changed)
            if ($productSelected->getProduct() === $this) {
                $productSelected->setProduct(null);
            }
        }

        return $this;
    }
}
