<?php

namespace App\Filament\Resources\ConnectivityIndicators\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ConnectivityIndicatorForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('year_id')
                    ->relationship('year', 'year')
                    ->label('Año')
                    ->required(),
                TextInput::make('operating_airports')
                    ->label('Aeropuertos operativos')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('connected_destinations')
                    ->label('Destinos conectados')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('active_routes')
                    ->label('Rutas activas')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }
}
