<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Database\Seeder;

class CartSeeder extends Seeder
{
    public function run(): void
    {
        Cart::factory()
            ->count(10)
            ->has(
                CartItem::factory()
                    ->count(5)
            )
            ->create();
    }
}
