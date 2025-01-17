<?php
namespace App\Domain\Product\Http\Controllers;

use App\Domain\Product\Http\Requests\DeleteProductRequest;
use App\Domain\Product\Http\Requests\FindProductRequest;
use App\Domain\Product\Http\Requests\ShowProductRequest;
use App\Domain\Product\Http\Requests\StoreProductRequest;
use App\Domain\Product\Http\Requests\UpdateProductRequest;
use App\Domain\Product\Services\ProductService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;


class ProductController extends Controller
{
    protected ProductService $service;

    public function __construct(ProductService $service)
    {
        $this->service = $service;
    }

    public function show(ShowProductRequest $request)
    {
        return response()->json($this->service->getProduct($request->id));
    }

    public function find(FindProductRequest $request)
    {
        return response()->json($this->service->getProductsByFilter($request->all()));
    }    

    public function store(StoreProductRequest $request)
    {
        Log::debug('Store products', [$request->all()]);
        return response()->json($this->service->createProduct($request->all()), 201);
    }

    public function update(UpdateProductRequest $request)
    {
        return response()->json($this->service->updateProduct($request->except(['user_id', '_token'])), 201);
    }

    public function destroy(DeleteProductRequest $request)
    {
        $this->service->deleteProduct($request->id);
        return response()->json(null, 204);
    }
}
