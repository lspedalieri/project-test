<?php

namespace App\Http\Controllers;

use App\Domain\Order\Http\Requests\CreateOrderRequest;
use App\Domain\Order\Http\Requests\EditOrderRequest;
use App\Domain\Order\Http\Requests\StoreOrderRequest;
use App\Domain\Order\Http\Requests\UpdateOrderRequest;
use App\Domain\Order\Services\OrderService;
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
        $items = $this->service->getAllOrders();

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
        $this->service->createOrder($request->all());
        return redirect(route('orders.index'));
    }

    public function edit(EditOrderRequest $request)
    {
        Log::debug('edit', [$request->all()]);
        $item = response()->json($this->service->getOrder($request->id));
        return Inertia::render('Orders/Edit', ['item' => $item, 'userId' => Auth::id()]);
    }

    public function update(UpdateOrderRequest $request)
    {
        $request->except('user_id');
        $this->service->updateOrder($request->except(['user_id', '_token']));
        return redirect(route('orders.index'));
    }    

    public function destroy(UpdateOrderRequest $request)
    {
        $request->except('user_id');
        $this->service->deleteOrder($request->id);
        return redirect(route('orders.index'));
    }    

}
