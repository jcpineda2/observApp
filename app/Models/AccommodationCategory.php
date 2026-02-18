<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AccommodationCategory extends Model
{
    /** @use HasFactory<\Database\Factories\AccommodationCategoryFactory> */
    use HasFactory;

    protected $fillable = [
        'category',
    ];

    public function accommodations(): HasMany
    {
        return $this->hasMany(Accommodation::class);
    }
}
