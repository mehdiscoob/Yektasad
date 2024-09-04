<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *     title="CartItem",
 *     description="CartItem model",
 *     @OA\Xml(name="CartItem")
 * )
 */
class CartItem extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'cart_items';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'cart_id',
        'product_id',
        'quantity',
    ];

    /**
     * Get the cart that owns the cart item.
     *
     * @return BelongsTo
     *
     * @OA\Property(
     *     property="cart",
     *     ref="#/components/schemas/Cart"
     * )
     */
    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }

    /**
     * Get the product associated with the cart item.
     *
     * @return BelongsTo
     *
     * @OA\Property(
     *     property="product",
     *     ref="#/components/schemas/Product"
     * )
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
