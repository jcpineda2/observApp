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
                TextEntry::make('accommodation.id')
                    ->label('Accommodation'),
                TextEntry::make('year.id')
                    ->label('Year'),
                TextEntry::make('month.id')
                    ->label('Month'),
                TextEntry::make('occupancy_rate')
                    ->numeric(),
                TextEntry::make('season')
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
