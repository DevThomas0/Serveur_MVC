<?php

declare(strict_types=1);

namespace Mini\Models;

class ProduitItem
{
 private int $productId;
 private string $productName;
 private float $productPrice;

 public function __construct(int $productId, string $productName, float $productPrice)
 {
  $this->productId = $productId;
  $this->productName = $productName;
  $this->productPrice = $productPrice;
 }

 public function getProductId(): int
 {
  return $this->productId;
 }

 public function getProductName(): string
 {
  return $this->productName;
 }

 public function setProductName(string $productName): void
 {
  $this->productName = $productName;
 }

 public function getProductPrice(): float
 {
  return $this->productPrice;
 }

 public function setProductPrice(float $productPrice): void
 {
  $this->productPrice = $productPrice;
 }

 // Formate le prix et retourn une string pour l'affichage
 public function displayProductInfo(): string
 {
  $formattedPrice = number_format($this->productPrice, 2, ',', ' ');
  return sprintf('%s - %s €', htmlspecialchars($this->productName), $formattedPrice);
 }
}
