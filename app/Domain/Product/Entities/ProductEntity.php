<?php

namespace App\Domain\Product\Entities;

class ProductEntity
{

    public function __construct(
        public int $id,
        public string $name,
        public ?string $description,
        public float $price,
        public string $barcode,
        public int $quantity,
        public ?int $restockTime
    ) {}
}
