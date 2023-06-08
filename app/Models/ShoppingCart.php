<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShoppingCart extends Model
{
    use HasFactory;

    protected $table = 'shopping_carts';
    protected $primaryKey = 'SHOPPING_CART_ID';
    public $timestamps = false;

    protected $fillable = [
        'PRODUCT_ID',
        'AMOUNT',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'PRODUCT_ID', 'PRODUCT_ID');
    }
}
