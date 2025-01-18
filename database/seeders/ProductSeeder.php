<?php

namespace Database\Seeders;

use App\Domain\Product\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public int $counter = 100;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for($i=0; $i<$this->counter; $i++){
            Product::insert([
                'name' => fake()->word(),
                'description' => fake()->paragraph(),
                'price' => fake()->randomFloat(2, 10, 100),
                'quantity' => fake()->randomNumber(3, false),
                'barcode' => fake()->isbn10(),
                'restock_time' => fake()->randomNumber(2, false)
            ]);
        }
    }
}
