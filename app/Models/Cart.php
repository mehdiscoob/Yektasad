<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *     title="Cart",
 *     description="Cart model",
 *     @OA\Xml(name="Cart")
 * )
 */
class Cart extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'carts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'expires_at',
    ];

    protected $hidden = [
        "deleted_at"
    ];

    /**
     * Get the cart items for the cart.
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
     * The products that belong to the cart.
     *
     * @return BelongsToMany
     *
     * @OA\Property(
     *     property="products",
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/Product")
     * )
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'cart_items')
            ->withPivot('quantity')
            ->withTimestamps();
    }
}
