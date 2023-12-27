<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\OrderDetailRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderDetailRepository::class)]
#[ApiResource]
class OrderDetail
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $comment = null;

    #[ORM\Column]
    private ?bool $delivery = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $depositDate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $retrieveDate = null;

    #[ORM\Column(length: 255)]
    private ?string $orderNumber = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $codePromo = null;

    #[ORM\ManyToOne(inversedBy: 'orderDetails')]
    private ?Client $client = null;

    #[ORM\ManyToOne(inversedBy: 'orderDetails')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Employee $emp = null;

    #[ORM\ManyToOne(inversedBy: 'orderDetails')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Payment $payment = null;

    #[ORM\ManyToOne(inversedBy: 'orderDetails')]
    #[ORM\JoinColumn(nullable: false)]
    private ?OrderStatus $orderStatus = null;

    #[ORM\OneToMany(mappedBy: 'orderDetail', targetEntity: ProductSelected::class)]
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

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): static
    {
        $this->comment = $comment;

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

    public function getCodePromo(): ?string
    {
        return $this->codePromo;
    }

    public function setCodePromo(?string $codePromo): static
    {
        $this->codePromo = $codePromo;

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
    public function getProuctSelected(): Collection
    {
        return $this->productSelected;
    }

    public function addProuctSelected(ProductSelected $prouctSelected): static
    {
        if (!$this->productSelected->contains($prouctSelected)) {
            $this->productSelected->add($prouctSelected);
            $prouctSelected->setOrderDetail($this);
        }

        return $this;
    }

    public function removeProuctSelected(ProductSelected $prouctSelected): static
    {
        if ($this->productSelected->removeElement($prouctSelected)) {
            // set the owning side to null (unless already changed)
            if ($prouctSelected->getOrderDetail() === $this) {
                $prouctSelected->setOrderDetail(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->id ? (string)$this->id : 'n/a';
    }

}
