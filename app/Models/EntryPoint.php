<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class EntryPoint extends Model
{
    /** @use HasFactory<\Database\Factories\EntryPointFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'entry_mode_id',
        'city_id',
        'is_active'
    ];

    protected $casts = [
        'entry_mode_id' => 'integer',
        'city_id' => 'integer',
        'is_active' => 'boolean',
    ];


    protected function name(): Attribute
    {
        return Attribute::make(
            set: fn($value) => Str::ucfirst(Str::lower($value)),
        );
    }
}
