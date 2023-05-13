<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Address extends Model
{
    use HasFactory;

    protected $primaryKey = 'ADDRESS_ID';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'NUMBER',
        'CEP',
        'UF',
        'DISTRICT',
        'PUBLIC_PLACE',
        'COMPLEMENT'
    ];

    public function users(): BelongsToMany
    {
        return $this->BelongsToMany(User::class, 'USER_ID', 'USER_ID');
    }

    public function supplier(): BelongsTo
    {
        return $this->BelongsTo(Supplier::class, 'SUPPLIER_ID', 'SUPPLIER_ID');
    }
}
