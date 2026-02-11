<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ServiceSector extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
    ];

    public function providers(): HasMany {
        return $this->hasMany(TourismProvider::class);
    }

    public function employments(): HasMany {
        return $this->hasMany(TourismEmployment::class);
    }
}
