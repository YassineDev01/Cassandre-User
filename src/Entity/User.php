<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $nom = null;

    #[ORM\Column(length: 100)]
    private ?string $prenom = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private string $password;

    #[ORM\Column]
    private bool $actif = true;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Role $role = null;

    // ------------------------
    // Getters & Setters
    // ------------------------
    public function getId(): ?int
    {
        return $this->id;
    }
    public function getNom(): ?string
    {
        return $this->nom;
    }
    public function setNom(string $nom): self
    {
        $this->nom = $nom;
        return $this;
    }
    public function getPrenom(): ?string
    {
        return $this->prenom;
    }
    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;
        return $this;
    }
    public function getEmail(): ?string
    {
        return $this->email;
    }
    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }
    public function getPassword(): string
    {
        return $this->password;
    }
    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }
    public function isActif(): bool
    {
        return $this->actif;
    }
    public function setActif(bool $actif): self
    {
        $this->actif = $actif;
        return $this;
    }
    public function getRole(): ?Role
    {
        return $this->role;
    }
    public function setRole(?Role $role): self
    {
        $this->role = $role;
        return $this;
    }

    // ------------------------
    // Symfony Security
    // ------------------------
    public function getUserIdentifier(): string
    {
        return (string)$this->email;
    }



    public function getRoles(): array
    {
        $roles = ['ROLE_USER']; // rôle Symfony par défaut
        if ($this->role) {
            $roles[] = 'ROLE_' . $this->role->getCode()->value;
        }
        return array_unique($roles);
    }


    public function eraseCredentials(): void {}

    public function __toString(): string
    {
        return $this->email;
    }
}
