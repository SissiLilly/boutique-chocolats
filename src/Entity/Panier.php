<?php

namespace App\Entity;

use App\Repository\PanierRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PanierRepository::class)]
class Panier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $contenu_panier = null;

  

    public function __construct()
    {
       
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContenuPanier(): ?string
    {
        return $this->contenu_panier;
    }

    public function setContenuPanier(?string $contenu_panier): self
    {
        $this->contenu_panier = $contenu_panier;

        return $this;
    }

    /**
     * @return PersistentCollection<int, Article>
     */




}
