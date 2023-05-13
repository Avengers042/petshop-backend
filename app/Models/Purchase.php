<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        'PRODUCT_ID',
        'USER_ID'
    ];

    public function products(): HasMany
    {
        return $this->HasMany(Product::class, 'PRODUCT_ID', 'PRODUCT_ID');
    }

    public function user(): BelongsTo
    {
        return $this->BelongsTo(User::class, 'USER_ID', 'USER_ID');
    }
}
