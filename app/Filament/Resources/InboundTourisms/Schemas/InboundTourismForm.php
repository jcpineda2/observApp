<?php

namespace App\Filament\Resources\InboundTourisms\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\Rule;

class InboundTourismForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('year_id')
                    ->label('Año')
                    ->relationship(
                        name: 'year',
                        titleAttribute: 'year',
                        modifyQueryUsing: fn(Builder $query) => $query->orderBy('year', 'desc'),
                    )
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('month_id')
                    ->label('Més')
                    ->relationship(
                        name: 'month',
                        titleAttribute: 'month',
                        modifyQueryUsing: fn(Builder $query) => $query->orderby('month_number', 'asc'),
                    )
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('residence_country_id')
                    ->relationship('country', 'name')
                    ->searchable()
                    ->preload()
                    ->label('Nacionalidad')
                    ->required(),

                Select::make('destination_department_id')
                    ->label('Departamento destino')
                    ->relationship('destinationDepartment', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),

                Select::make('entry_mode_id')
                    ->relationship('entryMode', 'description')
                    ->searchable()
                    ->preload()
                    ->label('Vía de Ingreso')
                    ->required(),
                Select::make('travel_reason_id')
                    ->relationship('travelReason', 'description')
                    ->searchable()
                    ->preload()
                    ->label('Motivo de viaje')
                    ->required()
                    ->rules(function (Get $get, $record) {
                        if (
                            ! $get('year_id') ||
                            ! $get('month_id') ||
                            ! $get('residence_country_id') ||
                            ! $get('destination_department_id') ||
                            ! $get('entry_mode_id') ||
                            ! $get('travel_reason_id')
                        ) {
                            return [];
                        }

                        $rule = Rule::unique('inbound_tourisms', 'travel_reason_id')
                            ->where(
                                fn($query) => $query
                                    ->where('year_id', $get('year_id'))
                                    ->where('month_id', $get('month_id'))
                                    ->where('residence_country_id', $get('residence_country_id'))
                                    ->where('destination_department_id', $get('destination_department_id'))
                                    ->where('entry_mode_id', $get('entry_mode_id'))
                            );

                        if ($record) {
                            $rule->ignore($record->getKey());
                        }

                        return [$rule];
                    })
                    ->validationMessages([
                        'unique' => 'Ya existe un registro para el Año, Mes, Nacionalidad, Departamento destino, Vía de ingreso y Motivo seleccionados.',
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
