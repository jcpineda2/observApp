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
                    ->relationship('accommodation', 'id')
                    ->required(),
                Select::make('year_id')
                    ->relationship('year', 'id')
                    ->required(),
                Select::make('month_id')
                    ->relationship('month', 'id')
                    ->required(),
                TextInput::make('occupancy_rate')
                    ->required()
                    ->numeric(),
                TextInput::make('season')
                    ->default(null),
            ]);
    }
}
