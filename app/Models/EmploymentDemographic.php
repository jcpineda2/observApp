<?php

namespace App\Models;

use App\Enums\Gender;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmploymentDemographic extends Model
{
    /** @use HasFactory<\Database\Factories\EmploymentDemographicFactory> */
    use HasFactory;

    protected $fillable = [
        'tourism_employment_id',
        'gender',
        'age_range',
        'people_count',
    ];

    protected $casts = [
        'gender' => Gender::class,
        'people_count' => 'integer',
    ];

    public function employment(): BelongsTo
    {
        return $this->belongsTo(TourismEmployment::class, 'tourism_employment_id');
    }
}
