<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Month extends Model
{
    /** @use HasFactory<\Database\Factories\MonthFactory> */
    use HasFactory;


    protected $fillable = [
        'month',
        'month_number',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    //Relaciones con otros modelos
    public function accommodationPerformances(): HasMany
    {
        return $this->hasMany(AccommodationPerformance::class);
    }

    public function inboundTourisms(): HasMany
    {
        return $this->hasMany(InboundTourism::class);
    }

    public function domesticTourisms(): HasMany
    {
        return $this->hasMany(DomesticTourism::class);
    }
}
