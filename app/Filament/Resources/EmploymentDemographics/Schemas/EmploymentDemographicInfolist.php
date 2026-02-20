<?php

namespace App\Filament\Resources\EmploymentDemographics\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class EmploymentDemographicInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('employment.serviceSector.description')
                    ->label('Rubro'),
                TextEntry::make('gender')
                    ->label('Género')
                    ->badge(),
                TextEntry::make('age_range'),
                TextEntry::make('people_count')
                    ->label('Rango de edades')
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
