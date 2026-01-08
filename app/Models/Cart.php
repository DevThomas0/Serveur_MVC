<?php

declare(strict_types=1);

namespace Mini\Models;

class Cart
{
    private array $items = [];

    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    public static function fromSession(): self
    {
        $items = [];
        if (isset($_SESSION['cart'])) {
            $stored = $_SESSION['cart'];
            if (is_array($stored)) {
                $items = $stored;
            }
        }
        return new self($items);
    }

    public function toSession(): void
    {
        $_SESSION['cart'] = $this->items;
    }

    public function addProduct(int $productId, int $quantity = 1): void
    {
        if ($quantity <= 0) {
            return;
        }
        $this->items[$productId] = ($this->items[$productId] ?? 0) + $quantity;
    }

    public function removeProduct(int $productId): void
    {
        unset($this->items[$productId]);
    }

    public function clear(): void
    {
        $this->items = [];
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function detailedLines(Catalogue $catalogue): array
    {
        $lines = [];
        foreach ($this->items as $productId => $qty) {
            $product = $catalogue->findById($productId);
            if (!$product) {
                continue;
            }
            $lines[] = [
                'product' => $product,
                'qty' => $qty,
                'total' => $product->getPrix() * $qty,
            ];
        }
        return $lines;
    }

    public function total(Catalogue $catalogue): float
    {
        $sum = 0;
        foreach ($this->detailedLines($catalogue) as $line) {
            $sum += $line['total'];
        }
        return $sum;
    }
}


