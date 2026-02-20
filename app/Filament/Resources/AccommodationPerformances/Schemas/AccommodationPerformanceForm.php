<?php

namespace App\Filament\Resources\AccommodationPerformances\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class AccommodationPerformanceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('accommodation_id')
                    ->relationship('accommodation.category', 'category')
                    ->label('Categoría de Alojamiento')
                    ->preload()
                    ->required(),
                Select::make('year_id')
                    ->relationship('year', 'year')
                    ->preload()
                    ->label('Año')
                    ->required(),
                Select::make('month_id')
                    ->relationship('month', 'month')
                    ->preload()
                    ->label('Més')
                    ->required(),
                TextInput::make('occupancy_rate')
                    ->label('Tasa de ocupación (%)')
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(100)
                    ->required(),
                TextInput::make('season')
                    ->label('Temporada')
                    ->default(null),
            ]);
    }
}
