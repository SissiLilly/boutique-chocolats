<?php

namespace App\Entity;

use App\Repository\ChocolatRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use \Doctrine\ORM\PersistentCollection;

#[ORM\Entity(repositoryClass: ChocolatRepository::class)]
class Chocolat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(type: "text", nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: "float")]
    private ?float $prix = null;


   
    #[ORM\Column(type: "text", nullable: true)]
    private  $imageName;

    /**
     * @var File|null
     * @Assert\Image()
     * @Vich\UploadableField(mapping="property_image", fileNameProperty="filename")
     */
    private $image;



    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\ManyToOne(targetEntity : Collection::class, inversedBy: 'chocolats')]
    #[ORM\JoinColumn(nullable: false)]
    private  $categorie = null;

    #[ORM\Column]
    private ?bool $isBest = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom_chocolat): self
    {
        $this->nom = $nom_chocolat;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description_chocolat): self
    {
        $this->description = $description_chocolat;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix_chocolat): self
    {
        $this->prix = $prix_chocolat;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageName(string $imageName): self
    {
        $this->imageName = $imageName;

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

    public function isIsBest(): ?bool
    {
        return $this->isBest;
    }

    public function setIsBest(bool $isBest): self
    {
        $this->isBest = $isBest;

        return $this;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }
}
