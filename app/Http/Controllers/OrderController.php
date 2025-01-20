<?php

namespace App\Http\Controllers;

use App\Domain\Order\Enums\OrderStatus;
use App\Domain\Order\Http\Requests\CreateOrderRequest;
use App\Domain\Order\Http\Requests\DeleteOrderRequest;
use App\Domain\Order\Http\Requests\EditOrderRequest;
use App\Domain\Order\Http\Requests\StoreOrderRequest;
use App\Domain\Order\Http\Requests\UpdateOrderRequest;
use App\Domain\Order\Services\OrderService;
use App\Domain\Product\Product;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{

    protected OrderService $service;

    public function __construct(OrderService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        Log::debug('order index');
        $items = $this->service->getUserOrders(Auth::id());

        Log::debug('items', [$items]);
        return Inertia::render('Orders/Index', ['items' => $items, 'userId' => Auth::id()]);
    }

    public function create(CreateOrderRequest $request)
    {
        Log::debug('create order form');
        return Inertia::render('Orders/Create', ['userId' => Auth::id()]);
    }

    public function store(StoreOrderRequest $request)
    {
        $product = Product::findOrFail($request->product_id);
        $user = User::findOrFail(Auth::id());
        $request->merge(['product' => $product, 'user' => $user, 'cost' => $product->price * $request->quantity]);
        $order = $this->service->createOrder($request->all());
        return redirect(route('products.index'));
    }

    public function edit(EditOrderRequest $request)
    {
        Log::debug('edit', [$request->all()]);
        $item = response()->json($this->service->getOrder($request->id, $request->user_id));
        return Inertia::render('Orders/Edit', ['item' => $item, 'userId' => Auth::id()]);
    }

    public function update(UpdateOrderRequest $request)
    {
        Log::debug('update order', [$request->all()]);
        $request->except('user_id');
        $this->service->updateOrder($request->except(['user_id', '_token']), $request->user_id);
        return redirect(route('orders.index'));
    }    

    public function destroy(DeleteOrderRequest $request)
    {
        $request->except('user_id');
        $this->service->deleteOrder($request->id, Auth::id());
        return redirect(route('orders.index'));
    }    

}
