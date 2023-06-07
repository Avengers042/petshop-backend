<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShoppingCart extends Model
{
    use HasFactory;

    protected $table = 'shopping_carts';
    protected $primaryKey = 'shopping_cart_id';
    public $timestamps = false;

    protected $fillable = [
        'product_id',
        'amount',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'PRODUCT_ID');
    }
}
