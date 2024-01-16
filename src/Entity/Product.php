<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ApiResource(
    normalizationContext:['groups'=>['products:read']],
    operations:[
        new GetCollection(),
        new Get()

    ]
    )]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['products:read', 'productSelected:read'])]
  

    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['products:read', 'productSelected:read'])]

    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    #[Groups(['products:read', 'productSelected:read'])]

    private ?Category $category = null;

    #[ORM\Column]
    #[Groups(['products:read', 'productSelected:read'])]
   
    private ?float $price = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['products:read', 'productSelected:read'])]

    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'product')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['products:read', 'productSelected:read'])]

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
