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
                    ->required(),
                Select::make('year_id')
                    ->relationship('year', 'year')
                    ->label('Año')
                    ->required(),
                Select::make('month_id')
                    ->relationship('month', 'month')
                    ->label('Més')
                    ->required(),
                TextInput::make('occupancy_rate')
                    ->label('Ocupación porcentaje')
                    ->required()
                    ->numeric(),
                TextInput::make('season')
                    ->label('Temporada')
                    ->default(null),
            ]);
    }
}
