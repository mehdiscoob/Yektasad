<?php

namespace App\Repositories\Cart;

use App\Models\Cart;
use App\Models\CartItem;
use Exception;

interface CartRepositoryInterface
{
    /**
     * Get the cart for the authenticated user.
     *
     * @return Cart
     */
    public function getCartForUser(): Cart;

    /**
     * Find a cart by its primary key.
     *
     * @param int $id
     * @return Cart|null
     */
    public function find(int $id): ?Cart;

    /**
     * Find a cart Item by its primary key.
     *
     * @param int $id
     * @return CartItem|null
     */
    public function findCartItem(int $id): ?CartItem;

    /**
     * Retrieve or create a cart for the given user.
     *
     * @param int $userId
     * @return Cart
     */
    public function getOrCreateCartForUser(int $userId): Cart;

    /**
     * Add an item to the cart.
     *
     * @param int $cartId
     * @param int $productId
     * @param int $quantity
     * @return Cart
     * @throws Exception
     */
    public function addItem(int $cartId, int $productId, int $quantity): Cart;

    /**
     * Remove an item from the cart.
     *
     * @param int $itemId
     * @return void
     */
    public function removeItem(int $itemId): void;

    /**
     * Clear expired carts.
     *
     * @return void
     */
    public function clearExpiredCarts(): void;
}
