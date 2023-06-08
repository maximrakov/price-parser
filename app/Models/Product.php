<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'link',
        'name',
        'price',
        'image'
    ];

    public function priceEntry(): HasMany
    {
        return $this->hasMany(PriceEntry::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
