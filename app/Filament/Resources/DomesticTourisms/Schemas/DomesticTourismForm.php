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
                    ->relationship('year', 'year')
                    ->label('Año')
                    ->required(),
                Select::make('month_id')
                    ->label('Més')
                    ->relationship('month', 'month')
                    ->required(),
                Select::make('destination_department_id')
                    ->relationship('department', 'name')
                    ->label('Dpartamento Destino')
                    ->required(),
                Select::make('travel_reason_id')
                    ->relationship('travelReason', 'description')
                    ->label('Motivos')
                    ->required(),
                TextInput::make('origin_region')
                    ->label('Region origen')
                    ->default(null),
                TextInput::make('tourist_quantity')
                    ->label('Cantidad de Turistas')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('total_spend')
                    ->label('Gasto Total')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('average_stay')
                    ->label('Estadía promedio')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('spend_composition')
                    ->label('Gasto total')
                    ->default(null),
            ]);
    }
}
