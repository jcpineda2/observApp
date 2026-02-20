<?php

namespace App\Filament\Resources\TravelReasons\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class TravelReasonInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('description')
                    ->label('Motivos de viaje'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
