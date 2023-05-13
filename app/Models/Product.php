<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    use HasFactory;

    protected $primaryKey = 'PRODUCT_ID';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'NAME',
        'DESCRIPTION',
        'SUPPLIER_ID'
    ];

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class, 'SUPPLIER_ID', 'SUPPLIER_ID');
    }

    public function purchase(): BelongsTo
    {
        return $this->BelongsTo(Purchase::class, 'PURCHASE_ID', 'PURCHASE_ID');
    }

    public function stock(): HasOne
    {
        return $this->hasOne(Supplier::class, 'STOCK_ID', 'STOCK_ID');
    }
}