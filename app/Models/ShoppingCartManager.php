<?php

declare(strict_types=1);

namespace Mini\Models;

class ShoppingCartManager
{
 private array $cartItems = [];

 public function __construct(array $cartItems = [])
 {
   $this->cartItems = $cartItems;
 }

 public static function loadFromSession(): self
 {
  $cartItems = [];
  if (isset($_SESSION['cart'])) {
   $stored = $_SESSION['cart'];
   // On verifie que c'est bien un array, au cas où
   if (is_array($stored)) {
    $cartItems = $stored;
   }
  }
  return new self($cartItems);
 }

 public function saveToSession(): void
 {
  $_SESSION['cart'] = $this->cartItems;
 }

 public function addProductToCart(int $productId, int $quantity = 1): void
 {
  if ($quantity <= 0) {
   return;
  }
  // On cumule les quantités si le produit est déjà dans le panier
  $this->cartItems[$productId] = ($this->cartItems[$productId] ?? 0) + $quantity;
 }

 public function removeProductFromCart(int $productId): void
 {
  unset($this->cartItems[$productId]);
 }

 public function clearCart(): void
 {
  $this->cartItems = [];
 }

 public function getCartItems(): array
 {
  return $this->cartItems;
 }

 // Retourne les lignes du panier avec les infos complètes des produits
 // On passe le catalogue pour pouvoir récuperer les détails
 public function getDetailedCartLines(ProductCatalogeManager $catalog): array
 {
   $lines = [];
  foreach ($this->cartItems as $productId => $qty) {
    $product = $catalog->findProductById($productId);
   // Si le produit existe plus dans le catalogue, on skip
   if (!$product) {
    continue;
   }
    $lines[] = [
     'product' => $product,
     'qty' => $qty,
     'total' => $product->getProductPrice() * $qty,
    ];
  }
  return $lines;
 }

 public function calculateTotalAmount(ProductCatalogeManager $catalog): float
 {
  $sum = 0;
   foreach ($this->getDetailedCartLines($catalog) as $line) {
    $sum += $line['total'];
   }
  return $sum;
 }
}
