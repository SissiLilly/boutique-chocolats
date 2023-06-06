<?php

namespace App\Entity;

use App\Repository\CollectionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use \Doctrine\ORM\PersistentCollection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CollectionRepository::class)]
class Collection
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nom_collection = null;

    #[ORM\OneToMany(mappedBy: 'categorie', targetEntity: Chocolat::class)]
    private $chocolats;

    #[ORM\OneToMany(mappedBy: 'categorie', targetEntity: Ideecadeau::class)]
    private PersistentCollection $ideecadeaus;

    public function __construct()
    {
        $this->chocolats = new ArrayCollection();
        $this->ideecadeaus = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomCollection(): ?string
    {
        return $this->nom_collection;
    }

    public function setNomCollection(?string $nom_collection): self
    {
        $this->nom_collection = $nom_collection;

        return $this;
    }

    /**
     * @return PersistentCollection<int, Chocolat>
     */

    /**
     * @return PersistentCollection<int, Chocolat>
     */
    public function getChocolats(): array
    {
        return $this->chocolats->toArray();
    }

    public function __toString(): string
    {
        return $this->nom_collection;
    }

    public function addChocolat(Chocolat $chocolat): self
    {
        if (!$this->chocolats->contains($chocolat)) {
            $this->chocolats->add($chocolat);
            $chocolat->setCategorie($this);
        }

        return $this;
    }

    public function removeChocolat(Chocolat $chocolat): self
    {
        if ($this->chocolats->removeElement($chocolat)) {
            // set the owning side to null (unless already changed)
            if ($chocolat->getCategorie() === $this) {
                $chocolat->setCategorie(null);
            }
        }

        return $this;
    }

    /**
     * @return PersistentCollection<int, Ideecadeau>
     */
    public function getIdeecadeaus(): PersistentCollection
    {
        return $this->ideecadeaus;
    }

    public function addIdeecadeau(Ideecadeau $ideecadeau): self
    {
        if (!$this->ideecadeaus->contains($ideecadeau)) {
            $this->ideecadeaus->add($ideecadeau);
            $ideecadeau->setCategorie($this);
        }

        return $this;
    }

    public function removeIdeecadeau(Ideecadeau $ideecadeau): self
    {
        if ($this->ideecadeaus->removeElement($ideecadeau)) {
            // set the owning side to null (unless already changed)
            if ($ideecadeau->getCategorie() === $this) {
                $ideecadeau->setCategorie(null);
            }
        }

        return $this;
    }
    
}
