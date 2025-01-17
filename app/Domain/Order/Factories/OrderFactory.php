<?php

namespace App\Domain\Order\Factories;

use App\Domain\Order\Order;
use App\Domain\Order\Entities\OrderEntity;
use App\Domain\Product\Entities\ProductEntity;
use App\Domain\Product\Factories\ProductFactory;
use App\Domain\Product\Product;
use App\Factories\UserFactory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Log;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory
{
    //private $statuses = [Order::STATUS_SENT, Order::STATUS_CANCELED, Order::STATUS_ORDERED];

    public static function fromModel(Order $order, User $userModel, Product $productModel): OrderEntity
    {
           
        $product = ProductFactory::fromModel($productModel);
        $user = UserFactory::fromModel($userModel);
        $notes = $order->notes;
        $status = $order->status;
        $quantity = $order->cost;
        $cost = $order->cost;

        Log::debug('order from model', [$order]);
        return new OrderEntity(
            id: $order->id,
            product: $product,
            user: $user,
            notes: $notes,
            status: $status,
            quantity: $quantity,
            cost: $cost
        );
    }
}
