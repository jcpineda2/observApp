<?php

namespace App\Models;

use App\Enums\Season;
use App\Models\Concerns\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AccommodationPerformance extends Model
{
    /** @use HasFactory<\Database\Factories\AccommodationPerformanceFactory> */
    use HasFactory;
    use Auditable;

    protected $fillable = [
        'year_id',
        'month_id',
        'state_id',
        'occupancy_rate',
        'season',
    ];

    protected $casts = [
        'year_id' => 'integer',
        'month_id' => 'integer',
        'state_id' => 'integer',
        'occupancy_rate' => 'decimal:2',
        'season' => Season::class,
    ];

    //Personaliza el nombre del módulo para auditoría
    public function getAuditModuleName(): string
    {
        return 'Desempeño de Alojamiento';
    }

    //Relaciones con otros modelos
    public function year(): BelongsTo
    {
        return $this->belongsTo(Year::class);
    }

    public function month(): BelongsTo
    {
        return $this->belongsTo(Month::class);
    }

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }
}
