<?php

namespace App\Filament\Resources\Airports\Schemas;

use Filament\Forms\Components\Select;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class AirportInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name')
                        ->label('Nombre'),
                TextEntry::make('country.name')
                    ->label('País'),
                TextEntry::make('city.name')
                    ->label('Ciudad'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
