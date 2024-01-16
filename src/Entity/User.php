<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\UserRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields:['email'], message:"Cet email existe déjà!")]
#[ORM\InheritanceType("JOINED")]
#[ORM\DiscriminatorColumn(name:"discr", type:"string")]
#[ORM\DiscriminatorMap([
    'user'=>User::class, 
    'client'=>Client::class,
    'employee'=>Employee::class
    ])]
#[ApiResource]
#[ApiFilter(SearchFilter::class, properties:['email'=>'ipartial'] )]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["order:read"])]

    protected ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Groups(["order:read"])]
    protected ?string $email = null;

    #[ORM\Column]
    #[Groups(["order:read"])]
    protected array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    protected ?string $password = null;

    #[ORM\Column(length: 255)]
    #[Groups(["order:read"])]
    protected ?string $firstname = null;

    #[ORM\Column(length: 255)]
    #[Groups(["order:read"])]
    protected ?string $lastname = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    protected ?\DateTimeInterface $birthday = null;

    #[ORM\Column(length: 10)]
    #[Groups(["order:read"])]

    protected ?string $phoneNumber = null;

    #[ORM\Column(length: 255)]
    #[Groups(["order:read"])]
    protected ?string $adress = null;

    #[ORM\Column]
    protected ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(length: 255, nullable: true)]
    protected ?string $profilUrl = null;

    #[ORM\ManyToOne(inversedBy: 'user')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["order:read"])]
    private ?ZipCode $zipCode = null;

    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(\DateTimeInterface $birthday): static
    {
        $this->birthday = $birthday;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): static
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(string $adress): static
    {
        $this->adress = $adress;

        return $this;
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

    public function getProfilUrl(): ?string
    {
        return $this->profilUrl;
    }

    public function setProfilUrl(?string $profilUrl): static
    {
        $this->profilUrl = $profilUrl;

        return $this;
    }

    public function getZipCode(): ?ZipCode
    {
        return $this->zipCode;
    }

    public function setZipCode(?ZipCode $zipCode): static
    {
        $this->zipCode = $zipCode;

        return $this;
    }

   
}
