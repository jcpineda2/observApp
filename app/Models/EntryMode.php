<?php

namespace App\Models;

use App\Models\Concerns\Auditable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class EntryMode extends Model
{
    /** @use HasFactory<\Database\Factories\EntryModeFactory> */
    use HasFactory;
    use Auditable;

    protected $fillable = [
        'description',
    ];


    protected function description(): Attribute
    {
        return Attribute::make(
            set: fn($value) => Str::ucfirst(Str::lower($value)),
        );
    }
    public function inboundTourisms(): HasMany
    {
        return $this->hasMany(InboundTourism::class);
    }

    public function entriesPoint(): HasMany
    {
        return $this->hasMany(EntryPoint::class);
    }
}
