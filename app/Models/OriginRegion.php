<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OriginRegion extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'sort_order',
    ];

    protected $casts = [
        'sort_order' => 'integer',
    ];

    public function domesticTourisms(): HasMany
    {
        return $this->hasMany(DomesticTourism::class);
    }
}
