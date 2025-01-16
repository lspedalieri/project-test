<?php

use App\Domain\Order\Order;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    private $statuses = [Order::STATUS_SENT, Order::STATUS_CANCELED, Order::STATUS_ORDERED];
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id')->comment('Product ID related to product table');
            $table->unsignedBigInteger('user_id')->comment('Buyer ID related to user table');
            $table->text('notes')->nullable()->comment('user notes about order');
            $table->enum('status', $this->statuses)->comment('status list');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
