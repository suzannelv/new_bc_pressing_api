<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
#[ApiResource]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['products:read', 'productSelected:read'])]
    private ?int $id = null;
    #[ORM\Column(length: 255)]
    #[Groups(['products:read', 'productSelected:read'])]
    private ?string $name = null;
    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'child')]
    #[ORM\JoinColumn(nullable: true)]
    private ?self $parent = null;
    #[ORM\OneToMany(mappedBy: 'parent', targetEntity: self::class)]
    private Collection $child;
    #[ORM\OneToMany(mappedBy: 'category', targetEntity: Product::class)]
    private Collection $products;

    public function __construct()
    {
        $this->child = new ArrayCollection();
        $this->products = new ArrayCollection();
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

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): static
    {
        $this->parent = $parent;
        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getChild(): Collection
    {
        return $this->child;
    }

    public function addChild(self $child): static
    {
        if (!$this->child->contains($child)) {
            $this->child->add($child);
            $child->setParent($this);
        }
        return $this;
    }

    public function removeChild(self $child): static
    {
        if ($this->child->removeElement($child)) {
            // set the owning side to null (unless already changed)
            if ($child->getParent() === $this) {
                $child->setParent(null);
            }
        }
        return $this;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): static
    {
        if (!$this->products->contains($product)) {
            $this->products->add($product);
            $product->setCategory($this);
        }
        return $this;
    }

    public function removeProduct(Product $product): static
    {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getCategory() === $this) {
                $product->setCategory(null);
            }
        }
        return $this;
    }

    public function getDisplayName():string
    {
       $level = $this->calculateLevel($this, 0);
       return str_repeat('——', $level) . $this->getName();
    }
    public function calculateLevel (?Category $category, int $level):int
    {
        if(null === $category->getParent()){
            return $level;
        }
        return $this->calculateLevel($category->getParent(), ++$level);
    }
    public function __toString(){
        return $this->name;
    }
}
