<?php
namespace App\Domain\Order\Http\Controllers;

use App\Domain\Order\Http\Requests\DeleteOrderRequest;
use App\Domain\Order\Http\Requests\FindOrderRequest;
use App\Domain\Order\Http\Requests\ShowOrderRequest;
use App\Domain\Order\Http\Requests\ShowOrdersRequest;
use App\Domain\Order\Http\Requests\StoreOrderRequest;
use App\Domain\Order\Http\Requests\UpdateOrderRequest;
use App\Domain\Order\Services\OrderService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class OrderController extends Controller
{
    protected OrderService $service;

    public function __construct(OrderService $service)
    {
        $this->service = $service;
    }

    public function show(ShowOrdersRequest $request)
    {
        return response()->json($this->service->getUserOrders(Auth::id()));
    }

    public function find(FindOrderRequest $request)
    {
        return response()->json($this->service->getOrdersByFilter($request->except(['_token']), Auth::id()));
    }    

    public function store(StoreOrderRequest $request)
    {
        Log::debug('Store orders', [$request->all()]);
        return response()->json($this->service->createOrder($request->all()), 201);
    }

    public function update(UpdateOrderRequest $request)
    {
        return response()->json($this->service->updateOrder($request->except(['user_id', '_token']), Auth::id()), 201);
    }

    public function destroy(DeleteOrderRequest $request)
    {
        $this->service->deleteOrder($request->id, Auth::id());
        return response()->json(null, 204);
    }
}
