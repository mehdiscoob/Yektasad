<?php

namespace Tests\Feature;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use JetBrains\PhpStorm\NoReturn;
use Tests\TestCase;

class CartTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(); // Load initial data if needed
    }

    /**
     * Test adding an item to the cart.
     *
     * @return void
     */
    public function test_add_item_to_cart()
    {
        $user = User::factory()->create();
        Auth::login($user);

        $product = Product::factory()->create();
        $response = $this->postJson('/api/cart', [
            'product_id' => $product->id,
            'quantity' => 2,
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'user_id',
                    'created_at',
                    'updated_at'
                ]
            ]);

        $this->assertDatabaseHas('cart_items', [
            'product_id' => $product->id,
            'quantity' => 2,
        ]);
    }

    /**
     * Test removing an item from the cart.
     *
     * @return void
     */
    public function test_remove_item_from_cart()
    {
        $user = User::factory()->create();
        Auth::login($user);

        $cart = Cart::factory()->create(['user_id' => $user->id]);
        $product = Product::factory()->create();
        $cartItem = CartItem::factory()->create([
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'quantity' => 2,
        ]);

        $response = $this->deleteJson('/api/cart/item/' . $cartItem->id);

        $response->assertStatus(200)
            ->assertJson(['message' => 'The item has been removed.']);

        $this->assertDatabaseMissing('cart_items', [
            'id' => $cartItem->id,
        ]);
    }

    /**
     * Test getting the cart.
     *
     * @return void
     */
    public function test_get_cart()
    {
        $user = User::factory()->create();
        Auth::login($user);

        $cart = Cart::factory()->create(['user_id' => $user->id]);

        $response = $this->getJson('/api/cart');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'user_id',
                    'created_at',
                    'updated_at'
                ]
            ]);
    }
}
