<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use \Doctrine\ORM\PersistentCollection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;








    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column]
    private ?\DateTime $createdAt = null;

    #[ORM\Column(length: 255)]
    private ?string $nomTransporteur = null;

    #[ORM\Column]
    private ?float $prixTransporteur = null;

    #[ORM\Column(length: 255)]
    private ?string $livraison = null;





    #[ORM\Column(length: 255)]
    private ?string $reference = null;

    #[ORM\Column(length: 255)]
    private ?string $product = null;

    #[ORM\Column]
    private ?int $quantite = null;

    #[ORM\Column]
    private ?float $prixCommande = null;

    #[ORM\Column]
    private ?float $prixProduit = null;

    #[ORM\Column(length: 255)]
    private ?string $EtatCommande = null;





    public function __construct()
    {
        $this->product = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }






    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getNomTransporteur(): ?string
    {
        return $this->nomTransporteur;
    }

    public function setNomTransporteur(string $nom_transporteur): self
    {
        $this->nomTransporteur = $nom_transporteur;

        return $this;
    }

    public function getPrixTransporteur(): ?float
    {
        return $this->prixTransporteur;
    }

    public function setPrixTransporteur(float $prix_transporteur): self
    {
        $this->prixTransporteur = $prix_transporteur;

        return $this;
    }

    public function getLivraison(): ?string
    {
        return $this->livraison;
    }

    public function setLivraison(string $livraison): self
    {
        $this->livraison = $livraison;

        return $this;
    }

    public function getProduct(): string
    {
        return $this->product;
    }





    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function setProduct(string $Product): self
    {
        $this->product = $Product;

        return $this;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getPrixCommande(): ?float
    {
        return $this->prixCommande;
    }

    public function setPrixCommande(float $prixCommande): self
    {
        $this->prixCommande = $prixCommande;

        return $this;
    }

    public function getPrixProduit(): ?float
    {
        return $this->prixProduit;
    }

    public function setPrixProduit(float $prixProduit): self
    {
        $this->prixProduit = $prixProduit;

        return $this;
    }

    public function getEtatCommande(): ?string
    {
        return $this->EtatCommande;
    }

    public function setEtatCommande(string $EtatCommande): self
    {
        $this->EtatCommande = $EtatCommande;

        return $this;
    }

 


}
