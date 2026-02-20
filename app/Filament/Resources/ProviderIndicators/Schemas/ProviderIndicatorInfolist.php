<?php

namespace App\Filament\Resources\ProviderIndicators\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ProviderIndicatorInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('year.year')
                    ->label('Año'),
                TextEntry::make('total_providers')
                    ->label('Total Prestadores')
                    ->numeric(),
                TextEntry::make('new_registrations')
                    ->label('Altas')
                    ->numeric(),
                TextEntry::make('cancellations')
                    ->label('Bajas')
                    ->numeric(),
                TextEntry::make('formalization_rate')
                    ->label('Porcentaje de Formalización')
                    ->numeric(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
