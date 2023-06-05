<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Address extends Model {
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

    public function users(): BelongsToMany {
        return $this->belongsToMany(User::class, 'USER_ID');
    }

    public function supplier(): BelongsTo {
        return $this->belongsTo(Supplier::class, 'SUPPLIER_ID');
    }
}
