<?php
namespace App\Domains\Orders\Repositories;

use App\Domain\Order\Order;

class OrderRepository
{
    public function create(array $data): Order
    {
        return Order::create($data);
    }

    public function update(Order $order, array $data): Order
    {
        $order->update($data);
        return $order;
    }

    public function delete(Order $order): void
    {
        $order->delete();
    }

    public function find(int $id): ?Order
    {
        return Order::find($id);
    }

    public function all()
    {
        return Order::all();
    }
}
