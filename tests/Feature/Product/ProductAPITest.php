<?php

use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;

test('Product screen can be rendered', function () {
    $user = User::factory()->create();

    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);    
    $response = $this->get('/products');

    $response->assertStatus(200);
});




// it('can list products', function () {
//     $this->getJson('/api/products/index')->assertStatus(200);
// });

// it('can create a product', function () {
//     $data = [
//         'name' => fake()->word(),
//         'description' => fake()->paragraph(1),
//         'price' => fake()->randomFloat(2, 10, 100),
//         'quantity' => fake()->randomNumber(3, false),
//         'barcode' => fake()->isbn10(),
//         'restock_time' => fake()->randomNumber(2, false)
//     ];
//     // 201 http created
//     $this->putJson('/api/products/store',$data)->assertStatus(201);
// });


