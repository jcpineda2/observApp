<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Month extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'month_number',
    ];

    public function inboundTourisms(): HasMany {
        return $this->hasMany(InboundTourism::class);
    }

    public function domesticTourisms(): HasMany {
        return $this->hasMany(DomesticTourism::class);
    }
}
