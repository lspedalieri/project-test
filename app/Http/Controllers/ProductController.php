<?php

namespace App\Http\Controllers;

use App\Domain\Product\Http\Requests\CreateProductRequest;
use App\Domain\Product\Http\Requests\EditProductRequest;
use App\Domain\Product\Services\ProductService;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{

    protected ProductService $service;

    public function __construct(ProductService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        Log::debug('product index');
        $items = $this->service->getAllProducts();

        Log::debug('items', [$items]);
        return Inertia::render('Products/Index', ['items' => $items]);
    }

    public function create(CreateProductRequest $request)
    {
        Log::debug('create product form');
        return Inertia::render('Products/Create', ['userId' => Auth::id()]);
    }

    public function edit(EditProductRequest $request)
    {
        $item = response()->json($this->service->getProduct($request->id));
        return Inertia::render('Products/Edit', [$item]);
    }

}
