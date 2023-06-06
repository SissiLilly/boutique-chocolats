<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]


class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "id")]
    private ?int $id ;

    #[ORM\Column(name: "nom")]
    
    private ?string $nom ;

    #[ORM\Column(name: "prenom")]
    public ?string $prenom ;


    #[ORM\Column(name: "email", length: 180, unique: true)]
    private string $email ;

    #[ORM\Column(name: "password")]
    private ?string $password ;

    #[ORM\Column(name: "role")]
    private array $roles = [];

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Adress::class)]
    private Collection $adresses;

    public function __construct()
    {
        $this->adresses = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->nom;
    }

    public function setUserName(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }


    public function getnom(): ?string
    {
        return $this->nom;
    }

    public function setnom(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function __toString() {
        return $this->nom;
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

   

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password_user): self
    {
        $this->password = $password_user;

        return $this;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        // nous devons nous assurer d'avoir au moins un rôle
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }
    

    public function setRoles(array $role_user): self
    {
        $this->roles = $role_user;

        return $this;
    }

    public function getSalt()
{
    // not needed when using the "bcrypt" algorithm in security.yaml
}

public function eraseCredentials()
{
    // remove sensitive data from the object
    // e.g. plain-text passwords
    $this->password ;
}

public function getUserIdentifier(): string
{
    return $this->email;
}

/**
 * @return Collection<int, Adress>
 */
public function getAdresses(): Collection
{
    return $this->adresses;
}

public function addAdress(Adress $adress): self
{
    if (!$this->adresses->contains($adress)) {
        $this->adresses->add($adress);
        $adress->setUser($this);
    }

    return $this;
}

public function removeAdress(Adress $adress): self
{
    if ($this->adresses->removeElement($adress)) {
        // set the owning side to null (unless already changed)
        if ($adress->getUser() === $this) {
            $adress->setUser(null);
        }
    }

    return $this;
}
}
