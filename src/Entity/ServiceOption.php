<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ServiceOptionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ServiceOptionRepository::class)]
#[ApiResource]
class ServiceOption
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?float $coefficentPrice = null;

    #[ORM\ManyToMany(targetEntity: ProductSelected::class, mappedBy: 'serviceOptions')]
    private Collection $product;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imagePath = null;

    public function __construct()
    {
        $this->product = new ArrayCollection();
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
    public function getProduct(): Collection
    {
        return $this->product;
    }

    public function addProduct(ProductSelected $product): static
    {
        if (!$this->product->contains($product)) {
            $this->product->add($product);
        }

        return $this;
    }

    public function removeProduct(ProductSelected $product): static
    {
        $this->product->removeElement($product);

        return $this;
    }

    public function getImagePath(): ?string
    {
        return $this->imagePath;
    }

    public function setImagePath(?string $imagePath): static
    {
        $this->imagePath = $imagePath;

        return $this;
    }
}
