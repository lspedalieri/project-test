<?php

namespace App\Domain\Product\Repositories;

use App\Domain\Product\Entities\ProductEntity;
use App\Domain\Product\Exceptions\ProductNotFoundException;
use App\Domain\Product\Factories\ProductFactory;
use App\Domain\Product\Product as ProductModel;
use Illuminate\Database\Eloquent\Builder;
use Carbon\CarbonInterface;
use DateTime;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use PhpParser\Node\Expr\Cast\Array_;

class ProductRepository
{
    public function create(
        string $name,
        ?string $description,
        float $price,
        ?int $quantity,
        string $barcode,
        ?int $restockTime,
    ): ProductEntity {
        DB::beginTransaction();
        try {
            /** @var ProductModel $product */
            $product = ProductModel::query()->create([
                'name' => $name,
                'description' => $description,
                'price' => $price,
                'quantity' => $quantity,
                'barcode' => $barcode,
                'restock_time' => $restockTime
            ]);
            Log::debug('product entity', [$product]);
        }catch(Exception $e){
            DB::rollBack();
            throw new Exception(
                $e->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );            
        }
        DB::commit();

        return ProductFactory::fromModel($product);
    }


    public function getProductsByFilter(
        ?string $name = null,
        ?string $description = null,
        ?float $min_price = null,
        ?float $max_price = null,
        ?int $quantity = null,
        ?string $barcode = null,
        ?int $restockTime = null,
        ?CarbonInterface $createdAt = null,
    ): array {
        $products = ProductModel::query()
            ->when($name, fn (Builder $query) => $query->where('name', 'LIKE', "%$name%"))
            ->when($description, fn (Builder $query) => $query->where('description', 'LIKE', "%$description%"))
            ->when($barcode, fn (Builder $query) => $query->where('barcode', 'LIKE', "%$barcode%"))
            ->when($min_price, fn (Builder $query) => $query->where('price', '>', $min_price))
            ->when($max_price, fn (Builder $query) => $query->where('price', '<', $max_price))
            ->when($restockTime, fn (Builder $query) => $query->where('restock_time', '=', $restockTime))
            ->when($createdAt, fn (Builder $query) => $query->whereDate('created_at', '=', $createdAt))
            ->get();
        Log::debug('products found', [$products]);
        return $products
            ->map(fn (ProductModel $product) => ProductFactory::fromModel($product))
            ->toArray();
    }

    public function getProductById(int $id) : ProductEntity
    {
        try {
            /** @var ProductModel $translation */
            $product = ProductModel::query()
                ->findOrFail($id);
        } catch (ProductNotFoundException $e) {
            throw new ProductNotFoundException($id, $e);
        }
        return ProductFactory::fromModel($product);
    }


    public function update(array $data): array
    {
        DB::beginTransaction();
        try {
            ProductModel::query()
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

    public function delete(int $productId): void
    {
        ProductModel::find($productId)->delete();
    }

    public function find(int $id): array
    {
        return ProductModel::where('id', $id)->get()
        ->map(fn (ProductModel $product) => ProductFactory::fromModel($product))
        ->toArray()
        ;
    }

    public function all(string $sortBy="id", string $order="asc", int $pagination = 10)
    {
        return ProductModel::orderBy($sortBy, $order)->get()   //->paginate($pagination);
        ->map(fn (ProductModel $product) => ProductFactory::fromModel($product))
        //->toArray()
        ;
    }

}
