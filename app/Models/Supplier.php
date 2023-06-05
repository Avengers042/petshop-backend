<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Supplier extends Model
{
    use HasFactory;

    protected $primaryKey = 'SUPPLIER_ID';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'CORPORATE_NAME',
        'TRADE_NAME',
        'CNPJ',
        'EMAIL',
        'COMMERCIAL_PHONE',
        'ADDRESS_ID'
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'PRODUCT_ID');
    }

    public function address(): HasOne
    {
        return $this->hasOne(Address::class, 'ADDRESS_ID', 'ADDRESS_ID');
    }
}
