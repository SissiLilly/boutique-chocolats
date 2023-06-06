<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
class Article
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $prix_article = null;

    #[ORM\Column]
    private ?int $quantite_article = null;

    public function __construct()
    {
       
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrixArticle(): ?float
    {
        return $this->prix_article;
    }

    public function setPrixArticle(float $prix_article): self
    {
        $this->prix_article = $prix_article;

        return $this;
    }

    public function getQuantiteArticle(): ?int
    {
        return $this->quantite_article;
    }

    public function setQuantiteArticle(int $quantite_article): self
    {
        $this->quantite_article = $quantite_article;

        return $this;
    }
}
