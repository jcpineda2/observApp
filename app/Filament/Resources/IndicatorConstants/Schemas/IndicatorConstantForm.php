<?php

namespace App\Filament\Resources\IndicatorConstants\Schemas;

use App\Enums\IndicatorDomain;
use App\Enums\IndicatorKey;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class IndicatorConstantForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('domain')
                    ->label('Dominio')
                    ->options(IndicatorDomain::class)
                    ->required(),
                Select::make('key')
                    ->label('Clave')
                    ->options(IndicatorKey::class)
                    ->required(),

                Select::make('year_id')
                    ->label('Año')
                    ->relationship('year', 'year', modifyQueryUsing: fn($query) => $query->orderByDesc('year'))
                    ->searchable()
                    ->preload()
                    ->nullable(),

                TextInput::make('value')
                    ->label('Valor')
                    ->numeric()
                    ->step('0.0001')
                    ->nullable(),

                TextInput::make('label')
                    ->label('Etiqueta')
                    ->maxLength(255)
                    ->nullable(),

                TextInput::make('unit')
                    ->label('Unidad')
                    ->maxLength(30)
                    ->nullable()
                    ->helperText('Ej: USD, noches, %, Gs.'),

                TextInput::make('source')
                    ->label('Fuente')
                    ->maxLength(255)
                    ->nullable(),

                Textarea::make('notes')
                    ->label('Notas')
                    ->rows(3)
                    ->nullable(),
            ]);
    }
}
