<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\CountryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CountryRepository::class)]
#[ApiResource]
class Country
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $country = null;

    #[ORM\OneToMany(mappedBy: 'country', targetEntity: ZipCode::class)]
    private Collection $zipCodes;

    public function __construct()
    {
        $this->zipCodes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): static
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @return Collection<int, ZipCode>
     */
    public function getZipCodes(): Collection
    {
        return $this->zipCodes;
    }

    public function addZipCode(ZipCode $zipCode): static
    {
        if (!$this->zipCodes->contains($zipCode)) {
            $this->zipCodes->add($zipCode);
            $zipCode->setCountry($this);
        }

        return $this;
    }

    public function removeZipCode(ZipCode $zipCode): static
    {
        if ($this->zipCodes->removeElement($zipCode)) {
            // set the owning side to null (unless already changed)
            if ($zipCode->getCountry() === $this) {
                $zipCode->setCountry(null);
            }
        }

        return $this;
    }
}
