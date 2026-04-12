<?php

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Queue;

uses(RefreshDatabase::class);

it('stores a guest order from the public userweb page', function () {
    Http::fake();
    Queue::fake();

    $category = Category::create([
        'name' => 'Burgers',
    ]);

    $product = Product::create([
        'category_id' => $category->id,
        'name' => 'Classic Burger',
        'qty' => 10,
        'price' => 7.50,
        'cost' => 3.00,
        'count' => 0,
        'description' => 'Test burger',
        'images' => ['burger.jpg'],
    ]);

    $response = $this->postJson('/order/store', [
        'total' => 15.00,
        'cart' => [
            [
                'id' => $product->id,
                'name' => $product->name,
                'price' => 7.50,
                'qty' => 2,
            ],
        ],
    ]);

    $response
        ->assertOk()
        ->assertJson([
            'message' => 'Order saved successfully',
        ]);

    $orderId = $response->json('order_id');

    expect($orderId)->not->toBeNull();

    $this->assertDatabaseHas('orders', [
        'id' => $orderId,
        'total_amount' => 15.00,
        'status' => 'pending',
        'user_id' => null,
    ]);

    $this->assertDatabaseHas('order_items', [
        'order_id' => $orderId,
        'product_id' => $product->id,
        'name' => 'Classic Burger',
        'quantity' => 2,
        'price' => 7.50,
    ]);

    expect($product->fresh()->qty)->toBe(8);
});
