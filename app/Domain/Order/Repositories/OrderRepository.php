<?php
namespace App\Domain\Order\Repositories;

use App\Domain\Order\Enums\OrderStatus;
use App\Domain\Order\Order;
use App\Domain\Order\Entities\OrderEntity;
use App\Domain\Order\Factories\OrderFactory;
use App\Domain\Product\Entities\ProductEntity;
use App\Domain\Product\Exceptions\OrderNotFoundException;
use Illuminate\Database\Eloquent\Builder;
use App\Domain\Product\Product;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use PhpParser\Node\Expr\Cast\String_;

class OrderRepository
{
    public function create(
        User $user,
        ProductEntity $product,
        ?string $notes,
        string $status,
        int $quantity,
        float $cost
    ): OrderEntity
    {
        DB::beginTransaction();
        try {
            /** @var Order $product */
            $order = Order::query()->create([
                'user_id' => $user->id,
                'product_id' => $product->id,
                'notes' => $notes,
                'status' => $status,
                'quantity' => $quantity,
                'cost'  => $cost
            ]);
            $orderFactory = OrderFactory::fromModel($order);
            Product::where('id', $product->id)->update(['quantity' => $product->quantity - $quantity]);
        }catch(Exception $e){
            DB::rollBack();
            throw new Exception(
                $e->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );            
        }
        DB::commit();
        return $orderFactory;
        
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


    public function update(array $data, int $user_id): array
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
        return $this->find($data['id'], $user_id);
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


    public function getOrdersByFilter(
        ?string $name,
        ?string $notes,
        ?OrderStatus $status,
        ?int $min_quantity,
        ?int $max_quantity,
        ?float $min_cost,
        ?float $max_cost
    ) : array
    {
        $orders = Order::query()
            ->when($name, fn (Builder $query) => $query->product->where('name', 'LIKE', "%$name%"))
            ->when($notes, fn (Builder $query) => $query->where('notes', 'LIKE', "%$notes%"))
            ->when($min_cost, fn (Builder $query) => $query->where('cost', '>', $min_cost))
            ->when($max_cost, fn (Builder $query) => $query->where('cost', '<', $max_cost))
            ->when($min_quantity, fn (Builder $query) => $query->where('quantity', '>', $min_quantity))
            ->when($max_quantity, fn (Builder $query) => $query->where('quantity', '<', $max_quantity))
//            ->when($createdAt, fn (Builder $query) => $query->whereDate('created_at', '=', $createdAt))
            ->get();
        Log::debug('products found', [$orders]);
        return $orders
            ->map(fn (Order $order) => OrderFactory::fromModel($order))
            ->toArray();        
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
        ->toArray()
        ;
    }
}
