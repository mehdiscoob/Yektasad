<?php

namespace Tests\Unit\Product;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Mail;
use App\Jobs\SendProductCreatedEmail;
use App\Mail\Product\ProductCreated;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use App\Models\User;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test creating a product successfully.
     *
     * @return void
     */
    public function test_create_product()
    {
        Queue::fake();
        Mail::fake();

        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $product=Product::factory()->make();
        $response = $this->postJson('/api/products', [
            'name' => $product->name,
            'price' => $product->price,
            'stock' => $product->stock,
        ]);

        $response->assertStatus(201);
        $response->assertJson([
            'name' => $product->name,
            'price' => $product->price,
            'stock' => $product->stock,
        ]);

        $this->assertDatabaseHas('products', [
            'name' => $product->name,
            'price' => $product->price,
            'stock' => $product->stock,
        ]);

        Queue::assertPushed(SendProductCreatedEmail::class);

        Mail::assertNotSent(ProductCreated::class);
    }

    /**
     * Test creating a product with validation errors.
     *
     * @return void
     */
    public function test_create_product_validation_error()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->postJson('/api/products', [
            'name' => '',
            'price' => -10.00,
            'stock' => -5,
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['name', 'price', 'stock']);
    }

}
