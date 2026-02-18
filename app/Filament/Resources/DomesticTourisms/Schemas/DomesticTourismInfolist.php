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
                TextEntry::make('year.id')
                    ->label('Year'),
                TextEntry::make('month.id')
                    ->label('Month'),
                TextEntry::make('destination_department_id')
                    ->numeric(),
                TextEntry::make('travelReason.id')
                    ->label('Travel reason'),
                TextEntry::make('origin_region')
                    ->placeholder('-'),
                TextEntry::make('tourist_quantity')
                    ->numeric(),
                TextEntry::make('total_spend')
                    ->numeric(),
                TextEntry::make('average_stay')
                    ->numeric(),
                TextEntry::make('spend_composition')
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
