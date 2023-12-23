<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ClientRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
#[ApiResource]
class Client extends User
{
    
    #[ORM\Column]
    private ?bool $membership = null;

   
    public function isMembership(): ?bool
    {
        return $this->membership;
    }

    public function setMembership(bool $membership): static
    {
        $this->membership = $membership;

        return $this;
    }
}
