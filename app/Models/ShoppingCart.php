<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShoppingCart extends Model
{
    use HasFactory;

    protected $primaryKey = 'SHOPPING_CART_ID';
    public $timestamps = false;
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'SHOPPING_CART_ID'
    ];

    public function product() : BelongsTo
    {
        return $this->belongsTo(Purchase::class, 'SHOPPING_CART_ID');
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'SHOPPING_CART_ID');
    }
}