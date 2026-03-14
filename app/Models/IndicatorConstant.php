<?php

namespace App\Models;

use App\Enums\IndicatorDomain;
use App\Enums\IndicatorKey;
use App\Filament\Resources\IndicatorConstants\IndicatorConstantResource;
use App\Models\Concerns\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IndicatorConstant extends Model
{
    use HasFactory;
    use Auditable;

    protected $fillable = [
        'domain',
        'year_id',
        'key',
        'value',
        'label',
        'unit',
        'source',
        'notes',
    ];

    protected $casts = [
        'domain' => IndicatorDomain::class,
        'key' => IndicatorKey::class,
        'value' => 'decimal:4',
    ];

    //Personaliza el nombre del módulo para auditoría
    public function getAuditModuleName(): string
    {
        return 'Constantes de Indicadores';
    }

    //Relaciones con otros modelos
    public function year(): BelongsTo
    {
        return $this->belongsTo(Year::class);
    }
}
