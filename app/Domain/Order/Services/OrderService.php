<?php
namespace App\Domains\Orders\Services;

use App\Domains\Orders\Repositories\OrderRepository;

class OrderService
{
    protected OrderRepository $repository;

    public function __construct(OrderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function createOrder(array $data)
    {
        return $this->repository->create($data);
    }

    public function updateOrder(int $id, array $data)
    {
        $order = $this->repository->find($id);
        if (!$order) {
            throw new \Exception("Order not found");
        }
        return $this->repository->update($order, $data);
    }

    public function deleteOrder(int $id)
    {
        $order = $this->repository->find($id);
        if (!$order) {
            throw new \Exception("Order not found");
        }
        $this->repository->delete($order);
    }

    public function getOrder(int $id)
    {
        return $this->repository->find($id);
    }

    public function getAllOrders()
    {
        return $this->repository->all();
    }
}
