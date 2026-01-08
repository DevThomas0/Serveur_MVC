<?php

declare(strict_types=1);

namespace Mini\Models;

class Produit
{
    private int $id;
    private string $nom;
    private float $prix;

    public function __construct(int $id, string $nom, float $prix)
    {
        $this->id = $id;
        $this->nom = $nom;
        $this->prix = $prix;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function setNom(string $nom): void
    {
        $this->nom = $nom;
    }

    public function getPrix(): float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): void
    {
        $this->prix = $prix;
    }

    public function afficher(): string
    {
        $formattedPrix = number_format($this->prix, 2, ',', ' ');
        return sprintf('%s - %s €', htmlspecialchars($this->nom), $formattedPrix);
    }
}



