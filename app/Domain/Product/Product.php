<?php

declare(strict_types=1);

namespace App\Domain\Product;

use App\Domain\Order\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property Collection<Orders> $orders
 */
class Product extends Model
{
    use HasFactory;

    protected $table = "products";

    protected $guarded = [];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public function orders() :HasMany
    {
        return $this->HasMany(Order::class, 'product_id', 'id');
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getBarcode(): string
    {
        return $this->barcode;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getRestockTime(): int
    {
        return $this->restockTime;
    }

    public function isLowStock(): bool
    {
        return $this->quantity < 10;
    }

}
