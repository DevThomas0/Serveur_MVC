<?php

declare(strict_types=1);

namespace Mini\Models;

class Commande
{
    private int $id;
    private array $lignes;
    private float $total;
    private string $date;

    public function __construct(int $id, array $lignes, float $total, string $date)
    {
        $this->id = $id;
        $this->lignes = $lignes;
        $this->total = $total;
        $this->date = $date;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getLignes(): array
    {
        return $this->lignes;
    }

    public function getTotal(): float
    {
        return $this->total;
    }

    public function getDate(): string
    {
        return $this->date;
    }
}


