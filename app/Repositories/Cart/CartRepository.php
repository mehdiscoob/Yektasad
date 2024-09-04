<?php

namespace App\Repositories\Cart;

use App\Models\Cart;
use App\Models\CartItem;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartRepository implements CartRepositoryInterface
{
    /**
     * @var Cart
     */
    protected Cart $cart;

    /**
     * @var CartItem
     */
    protected CartItem $cartItem;

    /**
     * CartRepository constructor.
     *
     * @param Cart $cart
     * @param CartItem $cartItem
     */
    public function __construct(Cart $cart, CartItem $cartItem)
    {
        $this->cart = $cart;
        $this->cartItem = $cartItem;
    }

    /**
     * Get the cart for the authenticated user.
     *
     * @return Cart
     */
    public function getCartForUser(): Cart
    {
        return $this->cart->firstOrCreate([
            'user_id' => Auth::id(),
            'expires_at' => Carbon::now()->addHours(24)
        ]);
    }

    /**
     * Find a cart by its primary key.
     *
     * @param int $id
     * @return Cart|null
     */
    public function find(int $id): ?Cart
    {
        return $this->cart->findOrFail($id);
    }

    /**
     * Find a cart Item by its primary key.
     *
     * @param int $id
     * @return CartItem|null
     */
    public function findCartItem(int $id): ?CartItem
    {
        return $this->cartItem->findOrFail($id);
    }

    /**
     * Retrieve or create a cart for the given user.
     *
     * @param int $userId
     * @return Cart
     */
    public function getOrCreateCartForUser(int $userId): Cart
    {
        return Cart::firstOrCreate(['user_id' => $userId]);
    }

    /**
     * Add an item to the cart.
     *
     * @param int $cartId
     * @param int $productId
     * @param int $quantity
     * @return Cart
     * @throws Exception
     */
    public function addItem(int $cartId, int $productId, int $quantity): Cart
    {
        $cart = Cart::findOrFail($cartId);


        DB::beginTransaction();

        try {
            $cart->products()->syncWithoutDetaching([$productId => ['quantity' => $quantity]], false);

            DB::commit();

            return $cart;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }


    /**
     * Remove an item from the cart.
     *
     * @param int $itemId
     * @return void
     */
    public function removeItem(int $itemId): void
    {
        $cartItem = $this->cartItem->findOrFail($itemId);
        if ($cartItem->cart->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }
        $cartItem->delete();
    }

    /**
     * Clear expired carts.
     *
     * @return void
     */
    public function clearExpiredCarts(): void
    {
        $this->cart->where('updated_at', '<', now()->subHours(24))->delete();
    }
}
