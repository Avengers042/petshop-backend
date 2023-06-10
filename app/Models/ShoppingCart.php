<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'SHOPPING_CART_ID');
    }

    public function purchases(): HasMany
    {
        return $this->hasMany(Purchase::class, 'SHOPPING_CART_ID');
    }
}
