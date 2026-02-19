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
                TextEntry::make('year.id')
                    ->label('Year'),
                TextEntry::make('serviceSector.id')
                    ->label('Service sector'),
                TextEntry::make('direct_employment')
                    ->numeric(),
                TextEntry::make('national_participation')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('interannual_variation')
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
