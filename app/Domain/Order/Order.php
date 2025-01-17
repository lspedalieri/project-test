<?php

namespace App\Domain\Order;

use App\Domain\Product\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{

    use HasFactory, SoftDeletes;

    protected $table = "orders";

    protected $guarded = [];

    protected $fillable = [
        'product_id',
        'user_id',
        'notes',
        'status',
        'quantity',
        'cost'
    ];

    public const STATUS_SENT = 'sent';
    public const STATUS_CANCELED = 'canceled';
    public const STATUS_ORDERED = 'ordered';    

    public function product() :BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }    

    public function user() :BelongsTo
    {
        return $this->belongsTo(User::class, 'product_id', 'id');
    }

}
