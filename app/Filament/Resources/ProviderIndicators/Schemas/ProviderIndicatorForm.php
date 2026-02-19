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
                    ->relationship('year', 'id')
                    ->required(),
                TextInput::make('total_providers')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('new_registrations')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('cancellations')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('formalization_rate')
                    ->required()
                    ->numeric()
                    ->default(0.0),
            ]);
    }
}
