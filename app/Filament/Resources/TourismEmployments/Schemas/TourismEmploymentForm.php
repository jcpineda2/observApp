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
                    ->relationship('year', 'id')
                    ->required(),
                Select::make('service_sector_id')
                    ->relationship('serviceSector', 'id')
                    ->required(),
                TextInput::make('direct_employment')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('national_participation')
                    ->numeric()
                    ->default(null),
                TextInput::make('interannual_variation')
                    ->numeric()
                    ->default(null),
            ]);
    }
}
