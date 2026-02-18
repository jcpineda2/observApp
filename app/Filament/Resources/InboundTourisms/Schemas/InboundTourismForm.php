<?php

namespace App\Filament\Resources\InboundTourisms\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class InboundTourismForm
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
                TextInput::make('residence_country_id')
                    ->required()
                    ->numeric(),
                Select::make('entry_mode_id')
                    ->relationship('entryMode', 'id')
                    ->required(),
                Select::make('travel_reason_id')
                    ->relationship('travelReason', 'id')
                    ->required(),
                TextInput::make('tourist_arrivals')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('excursionist_arrivals')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('foreign_exchange_revenue')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('average_spend')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('average_stay')
                    ->required()
                    ->numeric()
                    ->default(0.0),
            ]);
    }
}
