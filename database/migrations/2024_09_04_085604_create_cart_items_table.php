<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cart_id')
                ->constrained('carts')
                ->onDelete('cascade')
                ->name('fk_cart_id');

            $table->foreignId('product_id')
                ->constrained('products')
                ->onDelete('cascade')
                ->name('fk_product_id');
            $table->integer('quantity')->unsigned();
            $table->timestamps();
            $table->index('cart_id');
            $table->index('product_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};
