<?php
namespace App\Domain\Order\Services;

use App\Domain\Order\Entities\OrderEntity;
use App\Domain\Order\Enums\OrderStatus;
use App\Domain\Order\Repositories\OrderRepository;
use App\Domain\Product\Factories\ProductFactory;
use App\Domain\Product\Repositories\ProductRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class OrderService
{
    protected OrderRepository $repository;
    protected ProductRepository $productRepository;

    public function __construct(OrderRepository $repository, ProductRepository $productRepository)
    {
        $this->repository = $repository;
        $this->productRepository = $productRepository;
    }

    public function createOrder(array $data) : OrderEntity
    {
        Log::debug('product ent',[$data]);
        $productEntity = ProductFactory::fromModel($data['product']);
        return $this->repository->create(
            $data["user"],
            $productEntity,
            $data["notes"] ?? null,
            "ordered", //OrderStatus::STATUS_ORDERED,
            $data['quantity'],
            $data['cost'],
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

    public function deleteOrder(int $id, int $user_id): void
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
            user: $data["user"],
            product: $data["product"] ?? null,
            notes: $data["notes"] ?? null,
            status: $data["status"] ?? null,
            quantity: $data["quantity"] ?? null,
            cost: $data["cost"] ?? null
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
