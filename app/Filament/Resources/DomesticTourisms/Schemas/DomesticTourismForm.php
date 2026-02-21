<?php

namespace App\Filament\Resources\DomesticTourisms\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Illuminate\Validation\Rule;

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
                    ->label('Motivo')
                    ->required()
                    ->rules(function (Get $get, $record) {
                        $rule = Rule::unique('domestic_tourisms')
                            ->where(
                                fn($q) => $q
                                    ->where('year_id', $get('year_id'))
                                    ->where('month_id', $get('month_id'))
                                    ->where('destination_department_id', $get('destination_department_id'))
                                    ->where('travel_reason_id', $get('travel_reason_id'))
                            );

                        if ($record) {
                            $rule->ignore($record->getKey());
                        }

                        return [$rule];
                    })
                    ->validationMessages([
                        'unique' => 'Ya existe un registro para ese Año/Mes/Departamento/Motivo.',
                    ]),
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
