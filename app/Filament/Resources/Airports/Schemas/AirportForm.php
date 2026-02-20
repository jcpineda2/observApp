<?php

namespace App\Filament\Resources\Airports\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class AirportForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nombre')
                    ->required(),
                Select::make('country_id')
                    ->relationship('country','name')
                    ->label('País')
                    ->required(),
                Select::make('city_id')
                    ->label('Ciudad')
                    ->relationship('city', 'name')
                    ->required(),
            ]);
    }
}
