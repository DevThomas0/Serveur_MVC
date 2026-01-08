<?php

declare(strict_types=1);

namespace Mini\Models;

class Catalogue
{
    private array $produits = [];

    public function __construct(array $produits = [])
    {
        $this->produits = $produits;
    }

    public static function fromSession(): self
    {
        $produits = [];
        if (isset($_SESSION['catalogue'])) {
            $stored = unserialize((string) $_SESSION['catalogue'], ['allowed_classes' => true]);
            if (is_array($stored)) {
                $produits = $stored;
            }
        }

        return new self($produits);
    }

    public function toSession(): void
    {
        $_SESSION['catalogue'] = serialize($this->produits);
    }

    public function ajouterProduit(Produit $p): void
    {
        $this->produits[] = $p;
    }

    public function afficherCatalogue(): string
    {
        if (empty($this->produits)) {
            return '<p>Aucun produit pour le moment.</p>';
        }

        $items = array_map(function (Produit $p): string {
            $suffix = '';
            if ($p instanceof ProduitAlimentaire) {
                $suffix = ' (exp. ' . $p->afficherExpiration() . ')';
            }
            return '<li>' . $p->afficher() . $suffix . '</li>';
        }, $this->produits);

        return '<ul>' . implode('', $items) . '</ul>';
    }

    public function getProduits(): array
    {
        return $this->produits;
    }

    public function findById(int $id): ?Produit
    {
        foreach ($this->produits as $p) {
            if ($p->getId() === $id) {
                return $p;
            }
        }
        return null;
    }

    public function seedDefaultsIfEmpty(): void
    {
        if (!empty($this->produits)) {
            return;
        }

        $this->ajouterProduit(new Produit(1, 'Pomme', 0.60));
        $this->ajouterProduit(new Produit(2, 'Stylo', 1.20));
        $this->ajouterProduit(new ProduitAlimentaire(3, 'Yaourt', 2.50, '2025-12-31'));
    }

    public function prochaineId(): int
    {
        if (empty($this->produits)) {
            return 1;
        }

        $ids = array_map(static fn(Produit $p): int => $p->getId(), $this->produits);
        return max($ids) + 1;
    }
}


