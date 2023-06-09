<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Stock extends Model
{
    use HasFactory;

    protected $primaryKey = 'PRODUCT_ID';
    public $timestamps = false;
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'PRODUCT_ID',
        'AMOUNT',
    ];

    public function product(): HasOne
    {
        return $this->hasOne(Product::class, 'PRODUCT_ID', 'PRODUCT_ID');
    }
}
