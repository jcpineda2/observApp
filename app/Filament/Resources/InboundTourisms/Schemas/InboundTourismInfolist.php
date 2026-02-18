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
                TextEntry::make('year.id')
                    ->label('Year'),
                TextEntry::make('month.id')
                    ->label('Month'),
                TextEntry::make('residence_country_id')
                    ->numeric(),
                TextEntry::make('entryMode.id')
                    ->label('Entry mode'),
                TextEntry::make('travelReason.id')
                    ->label('Travel reason'),
                TextEntry::make('tourist_arrivals')
                    ->numeric(),
                TextEntry::make('excursionist_arrivals')
                    ->numeric(),
                TextEntry::make('foreign_exchange_revenue')
                    ->numeric(),
                TextEntry::make('average_spend')
                    ->numeric(),
                TextEntry::make('average_stay')
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
