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
                TextEntry::make('year.id')
                    ->label('Year'),
                TextEntry::make('total_providers')
                    ->numeric(),
                TextEntry::make('new_registrations')
                    ->numeric(),
                TextEntry::make('cancellations')
                    ->numeric(),
                TextEntry::make('formalization_rate')
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
