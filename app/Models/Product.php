<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *     title="Product",
 *     description="Product model",
 *     @OA\Xml(name="Product")
 * )
 */
class Product extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'products';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'price',
        'stock',
    ];

    /**
     * Get the cart items associated with the product.
     *
     * @return HasMany
     *
     * @OA\Property(
     *     property="cartItems",
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/CartItem")
     * )
     */
    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    /**
     * The carts that contain the product.
     *
     * @return BelongsToMany
     *
     * @OA\Property(
     *     property="carts",
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/Cart")
     * )
     */
    public function carts(): BelongsToMany
    {
        return $this->belongsToMany(Cart::class, 'cart_items')
            ->withPivot('quantity')
            ->withTimestamps();
    }
}
