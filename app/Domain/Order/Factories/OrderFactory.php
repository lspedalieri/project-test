<?php

namespace App\Domain\Order\Factories;

use App\Domain\Order\Order;
use App\Domain\Order\Entities\OrderEntity;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Log;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory
{
    //private $statuses = [Order::STATUS_SENT, Order::STATUS_CANCELED, Order::STATUS_ORDERED];

    public static function fromModel(Order $order): OrderEntity
    {
        // $order->loadMissing([
        //     'name',
        //     'description',
        //     'price',
        //     'quantity',
        //     'barcode',
        //     'restock_time',
        // ]);

        // public User $user,
        // public ProductEntity $product,
        // public string $notes,
        // public OrderStatus $status

        $userId = $order->user_id;
        $productId = $order->product_id;
        $notes = $order->notes;
        $status = $order->status;


        Log::debug('order from model', [$order]);
        return new OrderEntity(
            id: $order->id,
            productId: $productId,
            userId: $userId,
            notes: $notes,
            status: $status,
        );
    }
}
