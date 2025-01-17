<?php

namespace App\Domain\Product\Factories;

use App\Domain\Product\Entities\ProductEntity;
use App\Domain\Product\Product as Product;
use Illuminate\Support\Facades\Log;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory
{

    public static function fromModel(Product $product): ProductEntity
    {
        $name = $product->name;
        $description = $product->description;
        $price = $product->price;
        $quantity = $product->quantity;
        $barcode = $product->barcode;
        $restockTime = $product->restock_time;
        return new ProductEntity(
            id: $product->id,
            name: $name,
            description: $description,
            price: $price,
            quantity: $quantity,
            barcode: $barcode,
            restockTime: $restockTime,
        );
    }
}
