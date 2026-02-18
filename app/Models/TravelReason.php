<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TravelReason extends Model
{
    /** @use HasFactory<\Database\Factories\TravelReasonFactory> */
    use HasFactory;

    protected $fillable = [
        'description',
    ];

    public function inboundTourisms(): HasMany
    {
        return $this->hasMany(InboundTourism::class);
    }

    public function domesticTourisms(): HasMany
    {
        return $this->hasMany(DomesticTourism::class);
    }
}
