<?php

declare(strict_types=1);

namespace Mini\Models;

class ProduitAlimentaire extends Produit
{
    private string $dateExpiration;

    public function __construct(int $id, string $nom, float $prix, string $dateExpiration)
    {
        parent::__construct($id, $nom, $prix);
        $this->dateExpiration = $dateExpiration;
    }

    public function getDateExpiration(): string
    {
        return $this->dateExpiration;
    }

    public function setDateExpiration(string $dateExpiration): void
    {
        $this->dateExpiration = $dateExpiration;
    }

    public function afficherExpiration(): string
    {
        return htmlspecialchars($this->dateExpiration);
    }
}


