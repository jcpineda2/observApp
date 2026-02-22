<?php

namespace App\Filament\Resources\DomesticTourisms\Schemas;

use App\Models\State;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;
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
                    ->label('Departamento')
                    ->options(function ($record) {
                        $q = State::query()->orderBy('name');

                        // Solo Paraguay
                        $q->whereHas('country', fn($qq) => $qq->where('name', 'Paraguay'));

                        // pero incluir el actual si existe
                        if ($record?->destination_department_id) {
                            $q->orWhere('id', $record->destination_department_id);
                        }

                        return $q->pluck('name', 'id')->toArray();
                    })
                    ->required()
                    ->searchable(),
                Select::make('travel_reason_id')
                    ->relationship('travelReason', 'description')
                    ->label('Motivo')
                    ->required()
                    ->rules(function (Get $get, $record) {
                        $rule = Rule::unique('domestic_tourisms','travel_reason_id')
                            ->where(
                                fn($q) => $q
                                    ->where('year_id', $get('year_id'))
                                    ->where('month_id', $get('month_id'))
                                    ->where('destination_department_id', $get('department '))
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
