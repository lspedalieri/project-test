<?php
namespace App\Domain\Order\Services;

use App\Domain\Order\Entities\OrderEntity;
use App\Domain\Order\Enums\OrderStatus;
use App\Domain\Order\Repositories\OrderRepository;
use Illuminate\Support\Facades\Auth;

class OrderService
{
    protected OrderRepository $repository;

    public function __construct(OrderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function createOrder(array $data) : OrderEntity
    {
        return $this->repository->create(
            $data["user"],
            $data["product"],
            $data["notes"] ?? null,
            OrderStatus::STATUS_ORDERED
        );
    }

    public function updateOrder(array $data, $user_id)
    {
        $order = $this->repository->find($data['id'], $user_id);
        if (!$order) {
            throw new \Exception("Order not found");
        }
        return $this->repository->update($order, $data);
    }

    public function deleteOrder(int $id, $user_id)
    {
        $order = $this->repository->find($id, $user_id);
        if (!$order) {
            throw new \Exception("Order not found");
        }
        $this->repository->delete($id, $user_id);
    }


    public function getOrdersByFilter(array $data): array
    {
        return $this->repository->getOrdersByFilter(
            user_id: $data["user_id"],
            product: $data["product"] ?? null,
            notes: $data["notes"] ?? null,
            status: $data["status"] ?? null
        );        
    }

    public function getOrder(int $id, $user_id)
    {
        return $this->repository->find($id, $user_id);
    }

    public function getUserOrders($user_id)
    {
        return $this->repository->findUserOrders($user_id);
    }
}
