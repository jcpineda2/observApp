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
                    ->label('Año')
                    ->relationship('year', 'year')
                    ->required(),
                Select::make('month_id')
                    ->label('Més')
                    ->relationship('month', 'month')
                    ->required(),
                Select::make('residence_country_id')
                    ->relationship('country','name')
                    ->label('País de Residencia')
                    ->required(),
                Select::make('entry_mode_id')
                    ->relationship('entryMode', 'description')
                    ->label('Vía de Ingreso')
                    ->required(),
                Select::make('travel_reason_id')
                    ->relationship('travelReason', 'description')
                    ->label('Motivo de viaje')
                    ->required(),
                TextInput::make('tourist_arrivals')
                    ->label('Llegadas Turistas')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('excursionist_arrivals')
                    ->label('Llegadas Excursionistas')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('foreign_exchange_revenue')
                    ->label('Ingreso de divisas')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('average_spend')
                    ->label('Gasto promedio')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('average_stay')
                    ->label('Estadía primedio')
                    ->required()
                    ->numeric()
                    ->default(0.0),
            ]);
    }
}
