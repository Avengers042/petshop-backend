<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Stock extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'PRODUCT_ID',
        'AMOUNT',
    ];

    public $timestamps = false;

    public function product(): HasOne
    {
        return $this->HasOne(Product::class, 'PRODUCT_ID', 'PRODUCT_ID');
    }
}
