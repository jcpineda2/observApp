<?php

namespace App\Models;

use App\Enums\Gender;
use App\Models\Concerns\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmploymentDemographic extends Model
{
    use HasFactory;
    use Auditable;

    protected $fillable = [
        'tourism_employment_id',
        'gender',
        'age_range_id',
        'people_count',
    ];

    protected $casts = [
        'tourism_employment_id' => 'integer',
        'gender' => Gender::class,
        'age_range_id' => 'integer',
        'people_count' => 'integer',
    ];

    //función para hacer amigable el nombre del modelo al usuario
    public function getAuditModuleName(): string
    {
        return 'Empleo Demográfico';
    }

    //Relaciones con otros modelos
    public function employment(): BelongsTo
    {
        return $this->belongsTo(TourismEmployment::class, 'tourism_employment_id');
    }

    public function ageRange(): BelongsTo
    {
        return $this->belongsTo(AgeRange::class);
    }
}
