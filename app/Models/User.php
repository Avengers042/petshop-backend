<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Laravel\Sanctum\HasApiTokens;

class User extends Model {
    use HasApiTokens, HasFactory;

    protected $primaryKey = 'USER_ID';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'FIRST_NAME',
        'LAST_NAME',
        'CPF',
        'EMAIL',
        'AGE',
        'PASSWORD',
        'ADDRESS_ID'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'PASSWORD',
    ];

    public function purchases(): HasMany {
        return $this->hasMany(Purchase::class, 'PURCHASE_ID', 'PURCHASE_ID');
    }

    public function address(): HasOne {
        return $this->HasOne(Address::class, 'ADDRESS_ID', 'ADDRESS_ID');
    }
}
