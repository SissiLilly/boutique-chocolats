<?php

namespace App\Entity;

use App\Repository\IdeecadeauRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: IdeecadeauRepository::class)]
class Ideecadeau
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nom_ideecadeau = null;

    #[ORM\ManyToOne(inversedBy: 'ideecadeaus')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Collection $categorie = null;



    public function __construct()
    {
      
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomIdeecadeau(): ?string
    {
        return $this->nom_ideecadeau;
    }

    public function setNomIdeecadeau(?string $nom_ideecadeau): self
    {
        $this->nom_ideecadeau = $nom_ideecadeau;

        return $this;
    }

    public function getCategorie(): ?Collection
    {
        return $this->categorie;
    }

    public function setCategorie(?Collection $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }






}
