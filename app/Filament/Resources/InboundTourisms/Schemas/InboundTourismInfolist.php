<?php

namespace App\Filament\Resources\InboundTourisms\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class InboundTourismInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('year.year')
                    ->label('Año'),
                TextEntry::make('month.month')
                    ->label('Més'),
                TextEntry::make('country.name')
                    ->label('País de Residencia'),
                TextEntry::make('entryMode.description')
                    ->label('Vía de Ingreso'),
                TextEntry::make('travelReason.description')
                    ->label('Motivo de viaje'),
                TextEntry::make('tourist_arrivals')
                    ->label('Llegadas Turistas')
                    ->numeric(),
                TextEntry::make('excursionist_arrivals')
                    ->label('Llegadas Excursionistas')
                    ->numeric(),
                TextEntry::make('foreign_exchange_revenue')
                    ->label('Ingreso de divisas')
                    ->numeric(),
                TextEntry::make('average_spend')
                    ->label('Gasto promedio')
                    ->numeric(),
                TextEntry::make('average_stay')
                    ->label('Estadía primedio')
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
