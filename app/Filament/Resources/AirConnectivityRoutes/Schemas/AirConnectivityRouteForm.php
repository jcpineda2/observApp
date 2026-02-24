<?php

namespace App\Filament\Resources\AirConnectivityRoutes\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Validation\Rule;

class AirConnectivityRouteForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Periodo y Ruta')
                ->columns(3)
                ->components([
                    Select::make('year_id')
                        ->label('Año')
                        ->relationship('year', 'year')
                        ->preload()
                        ->searchable()
                        ->required(),

                    Select::make('month_id')
                        ->label('Mes')
                        ->relationship('month', 'month')
                        ->preload()
                        ->searchable()
                        ->required(),

                    Select::make('air_line_id')
                        ->label('Aerolínea')
                        ->relationship('airLine', 'name')
                        ->preload()
                        ->searchable()
                        ->required(),
                ]),

            Section::make('Origen / Destino')
                ->columns(2)
                ->components([
                    Select::make('origin_airport_id')
                        ->label('Aeropuerto Origen')
                        ->relationship('originAirport', 'name')
                        ->preload()
                        ->searchable()
                        ->required(),

                    Select::make('destination_airport_id')
                        ->label('Aeropuerto Destino')
                        ->relationship('destinationAirport', 'name')
                        ->preload()
                        ->searchable()
                        ->required()
                        // Validación anti-duplicado por período + aerolínea + ruta
                        ->rules([
                            fn ($get, $record) => Rule::unique('air_connectivity_routes', 'destination_airport_id')
                                ->where(fn ($q) => $q
                                    ->where('year_id', $get('year_id'))
                                    ->where('month_id', $get('month_id'))
                                    ->where('air_line_id', $get('air_line_id'))
                                    ->where('origin_airport_id', $get('origin_airport_id'))
                                )
                                ->ignore($record?->id),
                        ]),
                ]),

            Section::make('Estado y métricas (opcional)')
                ->columns(3)
                ->components([
                    Toggle::make('is_active')
                        ->label('Ruta activa')
                        ->default(true),

                    TextInput::make('flights_count')
                        ->label('Cantidad de vuelos (opcional)')
                        ->numeric()
                        ->minValue(0),

                    TextInput::make('seats_count')
                        ->label('Asientos (opcional)')
                        ->numeric()
                        ->minValue(0),
                ]),
        ]);
    }
}
