<?php

namespace App\Filament\Resources\AccommodationPerformances\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class AccommodationPerformanceInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('accommodation.category.category')
                    ->label('Categoría de Alojamiento'),
                TextEntry::make('year.year')
                    ->label('Año'),
                TextEntry::make('month.month')
                    ->label('Més'),
                TextEntry::make('occupancy_rate')
                    ->label('Ocupación porcentaje')
                    ->numeric(),
                TextEntry::make('season')
                    ->label('Temporada')
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
