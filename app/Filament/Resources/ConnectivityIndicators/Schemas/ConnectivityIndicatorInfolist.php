<?php

namespace App\Filament\Resources\ConnectivityIndicators\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ConnectivityIndicatorInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('year.year')
                    ->label('Año'),
                TextEntry::make('operating_airports')
                    ->label('Aeropuertos operativos')
                    ->numeric(),
                TextEntry::make('connected_destinations')
                    ->label('Destinos conectados')
                    ->numeric(),
                TextEntry::make('active_routes')
                    ->label('Rutas activas')
                    ->numeric(),
                TextEntry::make('created_at')
                    ->label('Rutas activas')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
