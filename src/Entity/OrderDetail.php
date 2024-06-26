<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\OrderDetailRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: OrderDetailRepository::class)]
#[ApiResource(
    normalizationContext:["groups"=>["order:read"]], 
    denormalizationContext:["groups" => "order:create"]
)]
#[ApiFilter(SearchFilter::class, properties:['client'=>'exact'])]
#[ApiFilter(OrderFilter::class, properties: ['createdAt'=>'DESC'])]

class OrderDetail
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['productSelected:read', "order:read"])]
    private ?int $id = null;

    #[ORM\Column]
    #[Groups(['productSelected:read', "order:read"])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    #[Groups(['productSelected:read', "order:read", "order:create"])]
    private ?bool $delivery = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['productSelected:read', "order:read", "order:create"])]
    private ?\DateTimeInterface $depositDate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['productSelected:read', "order:read", "order:create"])]
    private ?\DateTimeInterface $retrieveDate = null;

    #[ORM\Column(length: 255)]
    #[Groups(['productSelected:read', "order:read"])]
    private ?string $orderNumber = null;

    #[ORM\ManyToOne(inversedBy: 'orderDetails')]
    #[Groups(["order:read", "order:create"])]
    private ?Client $client = null;

    #[ORM\ManyToOne(inversedBy: 'orderDetails')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["order:read", "order:create"])]
    private ?Employee $emp = null;

    #[ORM\ManyToOne(inversedBy: 'orderDetails')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["order:read", "order:create"])]
    private ?Payment $payment = null;

    #[ORM\ManyToOne(inversedBy: 'orderDetails')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["order:read", "order:create"])]
    private ?OrderStatus $orderStatus = null;

    #[ORM\OneToMany(mappedBy: 'orderDetail', targetEntity: ProductSelected::class, cascade: ['persist'])]
    #[Groups(["order:read", "order:create"])]
    private Collection $productSelected;

    public function __construct()
    {
        $this->productSelected = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function isDelivery(): ?bool
    {
        return $this->delivery;
    }

    public function setDelivery(bool $delivery): static
    {
        $this->delivery = $delivery;

        return $this;
    }

    public function getDepositDate(): ?\DateTimeInterface
    {
        return $this->depositDate;
    }

    public function setDepositDate(\DateTimeInterface $depositDate): static
    {
        $this->depositDate = $depositDate;

        return $this;
    }

    public function getRetrieveDate(): ?\DateTimeInterface
    {
        return $this->retrieveDate;
    }

    public function setRetrieveDate(\DateTimeInterface $retrieveDate): static
    {
        $this->retrieveDate = $retrieveDate;

        return $this;
    }

    public function getOrderNumber(): ?string
    {
        return $this->orderNumber;
    }

    public function setOrderNumber(string $orderNumber): static
    {
        $this->orderNumber = $orderNumber;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): static
    {
        $this->client = $client;

        return $this;
    }

    public function getEmp(): ?Employee
    {
        return $this->emp;
    }

    public function setEmp(?Employee $emp): static
    {
        $this->emp = $emp;

        return $this;
    }

    public function getPayment(): ?Payment
    {
        return $this->payment;
    }

    public function setPayment(?Payment $payment): static
    {
        $this->payment = $payment;

        return $this;
    }

    public function getOrderStatus(): ?OrderStatus
    {
        return $this->orderStatus;
    }

    public function setOrderStatus(?OrderStatus $orderStatus): static
    {
        $this->orderStatus = $orderStatus;

        return $this;
    }

    /**
     * @return Collection<int, ProductSelected>
     */
    public function getProductSelected(): Collection
    {
        return $this->productSelected;
    }

    public function addProductSelected(ProductSelected $productSelected): static
    {
        if (!$this->productSelected->contains($productSelected)) {
            $this->productSelected->add($productSelected);
            $productSelected->setOrderDetail($this);
        }

        return $this;
    }

    public function removeProductSelected(ProductSelected $productSelected): static
    {
        if ($this->productSelected->removeElement($productSelected)) {
            // set the owning side to null (unless already changed)
            if ($productSelected->getOrderDetail() === $this) {
                $productSelected->setOrderDetail(null);
            }
        }

        return $this;
    }

    // calculer le prix total
    public function getTotalPrice() :float{
        $totalPrice = 0;
        foreach($this->getProductSelected() as $productSelected) {
            $totalPrice += $productSelected->getTotalPrice();
        }
        return $totalPrice;
    }

    public function getTotalPriceAsString(): string
    {
        return sprintf('%.2f €', $this->getTotalPrice());
    }

    public function __toString(): string
    {
        return $this->id ? (string)$this->id : 'n/a';
    }

}
