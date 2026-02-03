<?php

namespace App\Entity;

use App\Repository\RoleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Enum\RoleCode;

#[ORM\Entity(repositoryClass: RoleRepository::class)]
class Role
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(enumType: RoleCode::class, length: 50, unique: true)]
    private ?RoleCode $code = null;

    #[ORM\Column(length: 100)]
    private ?string $libelle = null;

    #[ORM\Column]
    private bool $system = false;

    #[ORM\OneToMany(mappedBy: 'role', targetEntity: User::class)]
    private Collection $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    public function getCode(): ?RoleCode
    {
        return $this->code;
    }
    public function setCode(RoleCode $code): self
    {
        $this->code = $code;
        return $this;
    }
    public function getLibelle(): ?string
    {
        return $this->libelle;
    }
    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;
        return $this;
    }
    public function isSystem(): bool
    {
        return $this->system;
    }
    public function setSystem(bool $system): self
    {
        $this->system = $system;
        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->setRole($this);
        }
        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            if ($user->getRole() === $this) {
                $user->setRole(null);
            }
        }
        return $this;
    }

    public function __toString(): string
    {
        return $this->libelle ?? $this->code?->value ?? '';
    }

    public function getCodeLabel(): string
    {
        return $this->code?->label() ?? '';
    }
}
