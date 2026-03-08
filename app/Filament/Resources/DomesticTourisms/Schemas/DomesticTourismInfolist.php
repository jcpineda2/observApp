<?php

namespace App\Filament\Resources\DomesticTourisms\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class DomesticTourismInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('year.year')
                    ->label('Año'),
                TextEntry::make('month.month')
                    ->label('Més'),
                TextEntry::make('department.name')
                    ->label('Dpartamento Destino')
                    ->numeric(),
                TextEntry::make('travelReason.description')
                    ->label('Motivo'),

                TextEntry::make('tourist_quantity')
                    ->label('Cantidad de Turistas')
                    ->numeric(),
                TextEntry::make('total_spend')
                    ->label('Gasto Total')
                    ->numeric(),
                TextEntry::make('average_stay')
                    ->label('Estadía promedio')
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
