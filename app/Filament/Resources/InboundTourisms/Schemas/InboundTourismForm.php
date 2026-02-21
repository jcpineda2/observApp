<?php

namespace App\Filament\Resources\InboundTourisms\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Illuminate\Validation\Rule;

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
                    ->relationship('country', 'name')
                    ->label('País de Residencia')
                    ->required(),
                Select::make('entry_mode_id')
                    ->relationship('entryMode', 'description')
                    ->label('Vía de Ingreso')
                    ->required(),
                Select::make('travel_reason_id')
                    ->relationship('travelReason', 'description')
                    ->label('Motivo de viaje')
                    ->required()
                    ->rules(function (Get $get, $record) {
                        $rule = Rule::unique('inbound_tourisms', 'travel_reason_id')
                            ->where(
                                fn($q) => $q
                                    ->where('year_id', $get('year_id'))
                                    ->where('month_id', $get('month_id'))
                                    ->where('residence_country_id', $get('residence_country_id'))
                                    ->where('entry_mode_id', $get('entry_mode_id'))
                                    ->where('travel_reason_id', $get('travel_reason_id'))
                            );

                        if ($record) {
                            $rule->ignore($record->getKey());
                        }

                        return [$rule];
                    })
                    ->validationMessages([
                        'unique' => 'Ya existe un registro con la misma combinación (Año, Mes, País, Vía de ingreso y Motivo).',
                    ]),
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
