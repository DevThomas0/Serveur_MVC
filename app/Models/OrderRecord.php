<?php

declare(strict_types=1);

namespace Mini\Models;

// Simple record pour stocker une commande
// On garde juste les infos essentielles, pas besoin de plus pour l'instant
class OrderRecord
{
 private int $orderId;
 private array $orderLines;
 private float $orderTotal;
 private string $orderDate;

 public function __construct(int $orderId, array $orderLines, float $orderTotal, string $orderDate)
 {
  $this->orderId = $orderId;
  $this->orderLines = $orderLines;
  $this->orderTotal = $orderTotal;
  $this->orderDate = $orderDate;
 }

 public function getOrderId(): int
 {
  return $this->orderId;
 }

 public function getOrderLines(): array
 {
  return $this->orderLines;
 }

 public function getOrderTotal(): float
 {
  return $this->orderTotal;
 }

 public function getOrderDate(): string
 {
  return $this->orderDate;
 }
}
