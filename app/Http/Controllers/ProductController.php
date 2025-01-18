<?php

namespace App\Http\Controllers;

use App\Domain\Product\Http\Requests\CreateProductRequest;
use App\Domain\Product\Http\Requests\EditProductRequest;
use App\Domain\Product\Http\Requests\FindProductRequest;
use App\Domain\Product\Http\Requests\StoreProductRequest;
use App\Domain\Product\Http\Requests\UpdateProductRequest;
use App\Domain\Product\Services\ProductService;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{

    protected ProductService $service;
    public int $defaultPagination = 10;

    public function __construct(ProductService $service)
    {
        $this->service = $service;
    }

    public function index(string $sortBy="id", string $order="asc", int $pagination = null)
    {
        Log::debug('product index');
        $pagination = (empty($pagination)) ? $this->defaultPagination: $pagination;
        $items = $this->service->getAllProducts($sortBy, $order, $pagination);

        Log::debug('items', [$items]);
        return Inertia::render('Products/Index', ['items' => $items, 'userId' => Auth::id()]);
    }

    public function find(FindProductRequest $request)
    {
        return Inertia::render('Products/Index', ['items' => $this->service->getProductsByFilter($request->all()), 'userId' => Auth::id()]);
    }

    public function create(CreateProductRequest $request)
    {
        Log::debug('create product form');
        return Inertia::render('Products/Create', ['userId' => Auth::id()]);
    }

    public function store(StoreProductRequest $request)
    {
        $this->service->createProduct($request->all());
        return redirect(route('products.index'))->withFlash('the Product is registered!');
    }

    public function edit(EditProductRequest $request)
    {
        Log::debug('edit', [$request->all()]);
        $item = response()->json($this->service->getProduct($request->id));
        return Inertia::render('Products/Edit', ['item' => $item, 'userId' => Auth::id()]);
    }

    public function update(UpdateProductRequest $request)
    {
        $request->except('user_id');
        $this->service->updateProduct($request->except(['user_id', '_token']));
        return redirect(route('products.index'))->withFlash('Product updated successfully.');;
    }    

    public function destroy(UpdateProductRequest $request)
    {
        $request->except('user_id');
        $this->service->deleteProduct($request->id);
        return redirect(route('products.index'))->withFlash('Product deleted.');;
    }    

}
