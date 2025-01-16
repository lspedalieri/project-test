<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Domain\Order\Order;
use App\Domain\Product\Product;
use App\Models\User;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition()
    {
        return [
            'product_id' => Product::factory(), // Associa a un prodotto generato
            'user_id' => User::factory(), // Associa a un utente generato
            'notes' => $this->faker->sentence(), // Note casuali
            'status' => $this->faker->randomElement(['inviato', 'cancellato', 'ordinato']), // Stato casuale
        ];
    }
}
