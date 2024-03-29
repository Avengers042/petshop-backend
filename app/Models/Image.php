<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Image extends Model
{
    use HasFactory;

    protected $primaryKey = 'IMAGE_ID';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'IMAGE_NAME',
        'IMAGE_ALT',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'IMAGE_ID');
    }
}
