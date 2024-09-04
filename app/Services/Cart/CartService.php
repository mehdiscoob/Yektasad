<?php

namespace App\Services\Cart;

use App\Models\Cart;
use App\Repositories\Cart\CartRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartService implements CartServiceInterface
{
    protected CartRepositoryInterface $cartRepository;
    protected ProductRepositoryInterface $productRepository;

    /**
     * CartService constructor.
     *
     * @param CartRepositoryInterface $cartRepository
     * @param ProductRepositoryInterface $productRepository
     */
    public function __construct(CartRepositoryInterface $cartRepository, ProductRepositoryInterface $productRepository)
    {
        $this->cartRepository = $cartRepository;
        $this->productRepository = $productRepository;
    }

    /**
     * Add an item to the cart.
     *
     * @param int $productId
     * @param int $quantity
     * @return Cart
     * @throws Exception
     */
    public function addItemToCart(int $productId, int $quantity): Cart
    {
        $userId = Auth::id();

        if (!$userId) {
            throw new Exception("User not authenticated.");
        }

        $product = $this->productRepository->find($productId);

        // Business logic: Check stock availability
        if ($product->stock < $quantity) {
            throw new Exception("Not enough stock available.");
        }

        DB::beginTransaction();

        try {
            $cart = $this->cartRepository->getOrCreateCartForUser($userId);
            $cart = $this->cartRepository->addItem($cart->id, $productId, $quantity);

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
     * @throws Exception
     */
    public function removeItemFromCart(int $itemId): void
    {
        $cartItem=$this->cartRepository->findCartItem($itemId);
        $cart=$this->cartRepository->find($cartItem->cart_id);
        if (Auth::id()!=$cart->user_id){
            throw new Exception("You don't have an access to this Cart");
        }
        $this->cartRepository->removeItem($itemId);
    }

    /**
     * Get the cart for the authenticated user.
     *
     * @return Cart
     */
    public function getCartForUser(): Cart
    {
        return $this->cartRepository->getCartForUser();
    }

    /**
     * Clear expired carts.
     *
     * @return void
     */
    public function clearExpiredCarts(): void
    {
        $this->cartRepository->clearExpiredCarts();
    }
}
