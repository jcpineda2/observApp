<?php

namespace App\Filament\Resources\DomesticTourisms\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class DomesticTourismForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('year_id')
                    ->relationship('year', 'id')
                    ->required(),
                Select::make('month_id')
                    ->relationship('month', 'id')
                    ->required(),
                TextInput::make('destination_department_id')
                    ->required()
                    ->numeric(),
                Select::make('travel_reason_id')
                    ->relationship('travelReason', 'id')
                    ->required(),
                TextInput::make('origin_region')
                    ->default(null),
                TextInput::make('tourist_quantity')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('total_spend')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('average_stay')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('spend_composition')
                    ->default(null),
            ]);
    }
}
