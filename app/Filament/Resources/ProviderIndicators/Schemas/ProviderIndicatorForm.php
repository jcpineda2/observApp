<?php

namespace App\Filament\Resources\ProviderIndicators\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ProviderIndicatorForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('year_id')
                    ->relationship('year', 'year')
                    ->label('Año')
                    ->preload()
                    ->required(),
                TextInput::make('total_providers')
                    ->label('Total Prestadores')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->default(0),
                TextInput::make('new_registrations')
                    ->label('Altas')
                    ->required()
                    ->minValue(0)
                    ->numeric()
                    ->default(0),
                TextInput::make('cancellations')
                    ->label('Bajas')
                    ->required()
                    ->minValue(0)
                    ->numeric()
                    ->default(0),
                TextInput::make('formalization_rate')
                    ->label('Tasa de formalización (%)')
                    ->minValue(0)
                    ->maxValue(100)
                    ->required()
                    ->numeric()
                    ->default(0.0),
            ]);
    }
}
