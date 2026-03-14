<?php

namespace App\Models;

use App\Models\Concerns\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DomesticTourism extends Model
{
    use HasFactory;
    use Auditable;

    protected $fillable = [
        'year_id',
        'month_id',
        'destination_department_id',
        'origin_region_id',
        'travel_reason_id',
        'tourist_quantity',
        'total_spend',
        'average_stay',
    ];

    protected $casts = [
        'year_id' => 'integer',
        'month_id' => 'integer',
        'destination_department_id' => 'integer',
        'origin_region_id' => 'integer',
        'travel_reason_id' => 'integer',
        'tourist_quantity' => 'integer',
        'total_spend' => 'decimal:2',
        'average_stay' => 'decimal:2',
    ];

    //Personaliza el nombre para auditoría
    public function getAuditModuleName(): string
    {
        return 'Turismo Interno';
    }

    //Relaciones a otros modelos
    public function year(): BelongsTo
    {
        return $this->belongsTo(Year::class);
    }

    public function month(): BelongsTo
    {
        return $this->belongsTo(Month::class);
    }

    public function destinationDepartment(): BelongsTo
    {
        return $this->belongsTo(State::class, 'destination_department_id');
    }

    public function originRegion(): BelongsTo
    {
        return $this->belongsTo(OriginRegion::class);
    }

    public function travelReason(): BelongsTo
    {
        return $this->belongsTo(TravelReason::class);
    }
}
