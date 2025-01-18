<?php

namespace App\Domain\Order\Factories;

use App\Domain\Order\Order;
use App\Domain\Order\Entities\OrderEntity;
use App\Domain\Order\Enums\OrderStatus;
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

    public static function fromModel(Order $order): OrderEntity
    {
        Log::debug('order model', [$order->status, $order, $order->product()->first(), $order->user()->first()]);
        $product = ProductFactory::fromModel($order->product()->first());
        $user = UserFactory::fromModel($order->user()->first()  );

        // $productId = $order->product_id;  
        // $userId = $order->user_id;        
        $notes = $order->notes;
        $quantity = $order->quantity;
        $cost = $order->cost;
        $status = $order->status;
        //$status = OrderStatus::from($status);

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
