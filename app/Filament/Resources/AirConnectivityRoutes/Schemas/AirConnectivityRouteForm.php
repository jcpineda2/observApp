<?php

namespace App\Filament\Resources\AirConnectivityRoutes\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;
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
                        ->relationship(
                            name: 'year',
                            titleAttribute: 'year',
                            modifyQueryUsing: fn(Builder $query) => $query->orderBy('year', 'desc')
                        )
                        ->preload()
                        ->searchable()
                        ->required(),

                    Select::make('month_id')
                        ->label('Mes')
                        ->relationship(
                            name: 'month',
                            titleAttribute: 'month',
                            modifyQueryUsing: fn(Builder $query) => $query->orderBy('month_number', 'asc')
                        )
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
                        ->rules(function (Get $get, $record) {
                            if (
                                ! $get('year_id') ||
                                ! $get('month_id') ||
                                ! $get('air_line_id') ||
                                ! $get('origin_airport_id') ||
                                ! $get('destination_airport_id')
                            ) {
                                return [];
                            }

                            $rule = Rule::unique('air_connectivity_routes', 'destination_airport_id')
                                ->where(
                                    fn($query) => $query
                                        ->where('year_id', $get('year_id'))
                                        ->where('month_id', $get('month_id'))
                                        ->where('air_line_id', $get('air_line_id'))
                                        ->where('origin_airport_id', $get('origin_airport_id'))
                                );

                            if ($record) {
                                $rule->ignore($record->getKey());
                            }

                            return [$rule];
                        })
                        ->validationMessages([
                            'unique' => 'Ya existe una ruta registrada para el Año, Mes, Aerolínea, Origen y Destino seleccionados.',
                        ])
                        ->different('origin_airport_id')
                        ->validationMessages([
                            'different' => 'El aeropuerto destino debe ser diferente al aeropuerto origen.',
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
                        ->minValue(0)
                        ->required(),

                    TextInput::make('seats_count')
                        ->label('Cantidad de asientos')
                        ->numeric()
                        ->minValue(0)
                        ->required(),
                ]),
        ]);
    }
}
