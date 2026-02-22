<?php

namespace App\Filament\Resources\TourismProviders\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class TourismProviderInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('serviceSector.id')
                    ->label('Rubro'),
                TextEntry::make('state_id')
                    ->label('Departamento')
                    ->numeric(),
                TextEntry::make('registration_date')
                    ->label('Fecha de registro')
                    ->date()
                    ->placeholder('-'),
                TextEntry::make('status')
                    ->badge(),
                TextEntry::make('created_at')
                    ->label('Estado')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
