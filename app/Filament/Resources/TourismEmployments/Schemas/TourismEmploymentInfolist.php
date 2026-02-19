<?php

namespace App\Filament\Resources\TourismEmployments\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class TourismEmploymentInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('year.year')
                    ->label('Año'),
                TextEntry::make('serviceSector.description')
                    ->label('Rubro'),
                TextEntry::make('direct_employment')
                    ->label('Empleo directo')
                    ->numeric(),
                TextEntry::make('national_participation')
                    ->label('Participación nacional')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('interannual_variation')
                    ->label('Variación interanual')
                    ->numeric()
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
