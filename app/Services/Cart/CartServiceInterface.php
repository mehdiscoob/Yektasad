<?php

namespace App\Services\Cart;

use App\Models\Cart;
use Exception;

interface CartServiceInterface
{
    /**
     * Add an item to the cart.
     *
     * @param int $productId
     * @param int $quantity
     * @return Cart
     * @throws Exception
     */
    public function addItemToCart(int $productId, int $quantity): Cart;

    /**
     * Remove an item from the cart.
     *
     * @param int $itemId
     * @return void
     */
    public function removeItemFromCart(int $itemId): void;

    /**
     * Get the cart for the authenticated user.
     *
     * @return Cart
     */
    public function getCartForUser(): Cart;

    /**
     * Clear expired carts.
     *
     * @return void
     */
    public function clearExpiredCarts(): void;
}
