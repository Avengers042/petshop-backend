<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

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
        'BIRTHDAY',
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
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'PASSWORD' => 'hashed',
    ];

    /**
     * Override the password output
     */
    public function getAuthPassword()
    {
        return $this->PASSWORD;
    }

    public function purchases() : HasMany
    {
        return $this->hasMany(Purchase::class, 'PURCHASE_ID');
    }

    public function address() : HasOne
    {
        return $this->hasOne(Address::class, 'ADDRESS_ID', 'ADDRESS_ID');
    }
}