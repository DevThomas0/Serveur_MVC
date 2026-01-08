<?php

declare(strict_types=1);

namespace Mini\Models;

class ProduitAlimentaireItem extends ProduitItem
{
 private string $expiratonDate;

 public function __construct(int $productId, string $productName, float $productPrice, string $expirationDate)
 {
  parent::__construct($productId, $productName, $productPrice);
   $this->expiratonDate = $expirationDate;
 }

 public function getExpiratonDate(): string
 {
   return $this->expiratonDate;
 }

 public function setExpiratonDate(string $expirationDate): void
 {
  $this->expiratonDate = $expirationDate;
 }

 // Affiche la date d'expiration formatée
 public function displayExpiratonDate(): string
 {
   return htmlspecialchars($this->expiratonDate);
 }
}
