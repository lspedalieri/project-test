<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->word(),
            'description' => fake()->paragraph(1),
            'price' => fake()->randomFloat(2, 10, 100),
            'quantity' => fake()->randomNumber(3, false),
            'barcode' => fake()->isbn10(),
            'restock_time' => fake()->randomNumber(2, false)
        ];
    }
}
