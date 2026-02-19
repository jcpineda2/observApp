<?php

namespace App\Filament\Resources\TourismEmployments\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class TourismEmploymentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('year_id')
                    ->relationship('year', 'year')
                    ->label('Año')
                    ->required(),
                Select::make('service_sector_id')
                    ->relationship('serviceSector', 'description')
                    ->label('Rubro')
                    ->required(),
                TextInput::make('direct_employment')
                    ->label('Empleo directo')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('national_participation')
                    ->label('Participación nacional')
                    ->numeric()
                    ->default(null),
                TextInput::make('interannual_variation')
                    ->label('Variación interanual')
                    ->numeric()
                    ->default(null),
            ]);
    }
}
