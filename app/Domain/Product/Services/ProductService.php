<?php

namespace App\Domain\Product\Services;

use App\Domain\Product\Entities\ProductEntity;
use App\Domain\Product\Product;
use App\Domain\Product\Repositories\ProductRepository;
use Carbon\CarbonInterface;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Type\Integer;

class ProductService
{
    protected ProductRepository $repository;

    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }

    public function createProduct(array $data) : ProductEntity
    {
        return $this->repository->create(
            $data["name"],
            $data["description"] ?? null,
            $data["price"],
            $data["quantity"] ?? null,
            $data["barcode"],
            $data["restock_time"] ?? null,
        );
    }


    public function getProductById(int $id): ProductEntity
    {
        return $this->repository->getProductById($id);
    }

    public function getProductsByFilter(array $data): array 
    {
        Log::debug('get products by filter');
        return $this->repository->getProductsByFilter(
            name: $data['name'] ?? null,
            description: $data['description'] ?? null,
            min_price: $data['min_price'] ?? null,
            quantity: $data['quantity'] ?? null,
            barcode: $data['barcode'] ?? null,
            restockTime: $data['restockTime'] ?? null,
            createdAt: $data['createdAt'] ?? null
        );
    }


    public function updateProduct(array $data) : array
    {
        $product = $this->repository->find($data['id']);
        if (!$product) {
            throw new \Exception("Product not found");
        }
        return $this->repository->update($data);
    }

    public function deleteProduct(int $id)
    {
        $product = $this->repository->find($id);
        if (!$product) {
            throw new \Exception("Product not found");
        }
        $this->repository->delete($id);
    }

    public function getProduct(int $id)
    {
        return $this->repository->find($id);
    }

    public function getAllProducts(string $sortBy="created_at", string $order="asc")
    {
        return $this->repository->all($sortBy, $order);
    }

    // public function getProductEntity(int $id): ?ProductEntity
    // {
    //     $product = $this->repository->find($id);
    //     if (!$product) {
    //         return null;
    //     }
    
    //     return new ProductEntity(
    //         $product->id,
    //         $product->name,
    //         $product->description,
    //         $product->price,
    //         $product->barcode,
    //         $product->quantity,
    //         $product->restock_time
    //     );
    // }
    
}
