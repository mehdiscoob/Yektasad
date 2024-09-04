<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cart\AddToCartRequest;
use App\Services\Cart\CartService;
use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CartController extends Controller
{
    private CartService $cartService;

    /**
     * CartController constructor.
     *
     * @param CartService $cartService
     */
    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    /**
     * @OA\Post(
     *     path="/api/cart",
     *     summary="Add an item to the cart",
     *     tags={"Cart"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="product_id", type="integer", example=1),
     *             @OA\Property(property="quantity", type="integer", example=2)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Item added to cart successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="user_id", type="integer", example=1),
     *                 @OA\Property(property="items", type="array",
     *                     @OA\Items(
     *                         @OA\Property(property="id", type="integer", example=1),
     *                         @OA\Property(property="product_id", type="integer", example=1),
     *                         @OA\Property(property="quantity", type="integer", example=2)
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Validation failed")
     *         )
     *     )
     * )
     * @throws Exception
     */
    public function addToCart(AddToCartRequest $request): JsonResponse
    {
        $cart = $this->cartService->addItemToCart(
            $request->input('product_id'),
            $request->input('quantity')
        );

        return response()->json(['data' => $cart], Response::HTTP_OK);
    }

    /**
     * @OA\Delete(
     *     path="/api/cart/items/{item_id}",
     *     summary="Remove an item from the cart",
     *     tags={"Cart"},
     *     @OA\Parameter(
     *         name="item_id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Item removed from cart successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The item has been removed.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Item not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Item not found")
     *         )
     *     )
     * )
     * @throws Exception
     */
    public function removeFromCart(int $item_id): JsonResponse
    {
        $this->cartService->removeItemFromCart($item_id);

        return response()->json(['message' => 'The item has been removed.'], Response::HTTP_OK);
    }

    /**
     * @OA\Get(
     *     path="/api/cart",
     *     summary="Get the cart for the current user",
     *     tags={"Cart"},
     *     @OA\Response(
     *         response=200,
     *         description="Cart retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="user_id", type="integer", example=1),
     *                 @OA\Property(property="items", type="array",
     *                     @OA\Items(
     *                         @OA\Property(property="id", type="integer", example=1),
     *                         @OA\Property(property="product_id", type="integer", example=1),
     *                         @OA\Property(property="quantity", type="integer", example=2)
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Cart not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Cart not found")
     *         )
     *     )
     * )
     */
    public function getCart(): JsonResponse
    {
        $cart = $this->cartService->getCartForUser();

        if (!$cart) {
            return response()->json(['message' => 'Cart not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json(['data' => $cart], Response::HTTP_OK);
    }
}
