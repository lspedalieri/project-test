<?php
namespace App\Domain\Order\Repositories;

use App\Domain\Order\Enums\OrderStatus;
use App\Domain\Order\Order;
use App\Domain\Order\Entities\OrderEntity;
use App\Domain\Order\Factories\OrderFactory;
use App\Domain\Product\Entities\ProductEntity;
use App\Domain\Product\Exceptions\OrderNotFoundException;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;

class OrderRepository
{
    public function create(
        User $user,
        ProductEntity $product,
        ?string $notes,
        OrderStatus $status
    ): OrderEntity
    {
        DB::beginTransaction();
        try {
            /** @var Order $product */
            $order = Order::query()->create([
                'user_id' => $user->id,
                'product_id' => $product->product_id,
                'notes' => $notes,
                'status' => $status
            ]);
        }catch(Exception $e){
            DB::rollBack();
            throw new Exception(
                $e->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );            
        }
        DB::commit();

        return OrderFactory::fromModel($order);
        
    }

    public function getOrderById(int $id) : OrderEntity
    {
        try {
            /** @var Order $translation */
            $order = Order::query()
                ->findOrFail($id);
        } catch (OrderNotFoundException $e) {
            throw new OrderNotFoundException($id, $e);
        }
        return OrderFactory::fromModel($order);
    }


    public function update(array $data): array
    {
        DB::beginTransaction();
        try {
            Order::query()
                ->where('id', '=', $data['id'])
                ->update($data);
        }catch(Exception $e){
            DB::rollBack();
            throw new Exception(
                $e->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );            
        }
        DB::commit();
        return $this->find($data['id']);
    }

    public function delete(int $orderId, int $user_id): void
    {
        Order::where(['id' => $orderId, 'user_id' => $user_id])->delete();
    }

    public function find(int $id, $user_id): array
    {
        return Order::where(['id' => $id, 'user_id' => $user_id])->get()
        ->map(fn (Order $order) => OrderFactory::fromModel($order))
        ->toArray()
        ;
    }


    public function getOrdersByFilter() : array
    {
        return [];
    }

    public function findUserOrders($user_id): array
    {
        return Order::where(['user_id' => $user_id])->get()
        ->map(fn (Order $order) => OrderFactory::fromModel($order))
        ->toArray();        
    }

    public function all()
    {
        return Order::all()
        ->map(fn (Order $order) => OrderFactory::fromModel($order))
        //->toArray()
        ;
    }
}
