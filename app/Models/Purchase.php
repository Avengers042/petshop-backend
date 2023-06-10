<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Purchase extends Model
{
    use HasFactory;

    protected $primaryKey = 'PURCHASE_ID';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'SHOPPING_CART_ID',
        'USER_ID',
        'PRODUCT_ID',
        'AMOUNT'
    ];

    public function products() : HasMany
    {
        return $this->hasMany(Product::class, 'PRODUCT_ID', 'PRODUCT_ID');
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'USER_ID', 'USER_ID');
    }

    public function shoppingCart() : BelongsTo
    {
        return $this->belongsTo(ShoppingCart::class, 'SHOPPING_CART_ID', 'SHOPPING_CART_ID');
    }
}