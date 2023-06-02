<?php

namespace App\Entity;

use App\Repository\PasswordRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PasswordRepository::class)]
class Password
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $date_de_creation_password = null;

    #[ORM\Column(length: 255)]
    private ?string $token_password = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDeCreationPassword(): ?string
    {
        return $this->date_de_creation_password;
    }

    public function setDateDeCreationPassword(string $date_de_creation_password): self
    {
        $this->date_de_creation_password = $date_de_creation_password;

        return $this;
    }

    public function getTokenPassword(): ?string
    {
        return $this->token_password;
    }

    public function setTokenPassword(string $token_password): self
    {
        $this->token_password = $token_password;

        return $this;
    }
}
