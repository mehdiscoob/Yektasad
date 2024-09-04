<?php

use App\Http\Controllers\Cart\CartController;
use App\Http\Controllers\Product\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('products', [ProductController::class, 'store']);
});
Route::middleware('auth:sanctum')->group(function () {
    Route::post('cart', [CartController::class, 'addToCart']);
    Route::delete('cart/item/{itemId}', [CartController::class, 'removeFromCart']);
    Route::get('cart', [CartController::class, 'getCart']);
});
