<?php

namespace App\Models;

use App\Enums\Gender;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmploymentDemographic extends Model
{
    //
    protected $fillable = [
        'tourism_employment_id',
        'gender',
        'age_range',
        'people_count',
    ];

    protected $casts = [
        'gender' => Gender::class,
    ];

    public function employment(): BelongsTo
    {
        return $this->belongsTo(TourismEmployment::class);
    }
}
