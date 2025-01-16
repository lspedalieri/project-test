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
    //private $statuses = [Order::STATUS_SENT, Order::STATUS_CANCELED, Order::STATUS_ORDERED];

    public static function fromModel(Product $product): ProductEntity
    {
        // $product->loadMissing([
        //     'name',
        //     'description',
        //     'price',
        //     'quantity',
        //     'barcode',
        //     'restock_time',
        // ]);

        $name = $product->name;
        $description = $product->description;
        $price = $product->price;
        $quantity = $product->quantity;
        $barcode = $product->barcode;
        $restock_time = $product->restock_time;
        Log::debug('product from model', [$product]);
        return new ProductEntity(
            id: $product->id,
            name: $name,
            description: $description,
            price: $price,
            quantity: $quantity,
            barcode: $barcode,
            restockTime: $restock_time
        );
    }
}
