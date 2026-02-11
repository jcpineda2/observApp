<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Year extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    // Relación con todos los indicadores que usan el año
    public function inboundTourisms(): HasMany {
        return $this->hasMany(InboundTourism::class);
    }

    public function domesticTourisms(): HasMany {
        return $this->hasMany(DomesticTourism::class);
    }

    public function tourismEmployments(): HasMany {
        return $this->hasMany(TourismEmployment::class);
    }
}
