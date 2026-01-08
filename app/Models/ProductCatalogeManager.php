<?php

declare(strict_types=1);

namespace Mini\Models;

class ProductCatalogeManager
{
 private array $productList = [];

 public function __construct(array $productList = [])
 {
  $this->productList = $productList;
 }

 // On récupere depuis la session, avec un fallback si ça plante
 public static function loadFromSession(): self
 {
  $productList = [];
  if (isset($_SESSION['catalogue'])) {
   $stored = unserialize((string) $_SESSION['catalogue'], ['allowed_classes' => true]);
   // Parfois unserialize peut renvoyer false si ça merde, on verifie
   if (is_array($stored)) {
    $productList = $stored;
   }
  }

  return new self($productList);
 }

 public function saveToSession(): void
 {
  $_SESSION['catalogue'] = serialize($this->productList);
 }

 public function addProductItem(ProduitItem $p): void
 {
  $this->productList[] = $p;
 }

 public function renderCatalogHTML(): string
 {
  if (empty($this->productList)) {
   return '<p>Aucun produit pour le moment.</p>';
  }

   $items = array_map(function (ProduitItem $p): string {
    $suffix = '';
    // Si c'est un produit alimentaire, on affiche la date d'expiration
    if ($p instanceof ProduitAlimentaireItem) {
     $suffix = ' (exp. ' . $p->displayExpiratonDate() . ')';
    }
    return '<li>' . $p->displayProductInfo() . $suffix . '</li>';
   }, $this->productList);

  return '<ul>' . implode('', $items) . '</ul>';
 }

 public function getAllProducts(): array
 {
  return $this->productList;
 }

 // Cherche un produit par son ID, retourn null si pas trouvé
 public function findProductById(int $id): ?ProduitItem
 {
  foreach ($this->productList as $p) {
   if ($p->getProductId() === $id) {
    return $p;
   }
  }
  return null;
 }

 // Initialise quelques produits de base si le catalogue est vide
 // TODO: à deplacer dans une seed ou un fichier de config plus tard
 public function initializeDefaultProductsIfEmpty(): void
 {
  if (!empty($this->productList)) {
   return;
  }

  $this->addProductItem(new ProduitItem(1, 'Pomme', 0.60));
  $this->addProductItem(new ProduitItem(2, 'Stylo', 1.20));
  $this->addProductItem(new ProduitAlimentaireItem(3, 'Yaourt', 2.50, '2025-12-31'));
 }

 public function getNextAvailableId(): int
 {
  if (empty($this->productList)) {
   return 1;
  }

  // On récupere tous les IDs et on prend le max + 1
  $ids = array_map(static fn(ProduitItem $p): int => $p->getProductId(), $this->productList);
  return max($ids) + 1;
 }
}
