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
                TextEntry::make('year.id')
                    ->label('Year'),
                TextEntry::make('operating_airports')
                    ->numeric(),
                TextEntry::make('connected_destinations')
                    ->numeric(),
                TextEntry::make('active_routes')
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
