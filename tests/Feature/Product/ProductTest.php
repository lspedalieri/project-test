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


test('Product creation screen can be rendered per admin users', function () {
    $user = User::factory()->create([
        'email'     => 'admin@admin.com',
        'roles' => 'admin',
        'password' => 'password'
    ]);

    $response = $this->post('/login', [
        'email'     => 'admin@admin.com',
        'password'  => 'password',
    ]);    
    $response = $this->get('/products/create');

    $response->assertStatus(200);
});


test('Product screen without login must redirect to login', function () {
    $response = $this->get('/products');

    $response->assertStatus(302);

});