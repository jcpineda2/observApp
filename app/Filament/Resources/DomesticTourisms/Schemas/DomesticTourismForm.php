<?php

namespace App\Filament\Resources\DomesticTourisms\Schemas;

use App\Models\State;
use Filament\Actions\CreateAction;
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
                    ->relationship(
                        name: 'year',
                        titleAttribute: 'year',
                        modifyQueryUsing: fn(Builder $query) => $query->orderBy('year', 'desc'),
                    )
                    ->label('Año')
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('month_id')
                    ->label('Mes')
                    ->relationship(
                        name: 'month',
                        titleAttribute: 'month',
                        modifyQueryUsing: fn(Builder $query) => $query->orderby('month_number', 'asc'),
                    )
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('destination_department_id')
                    ->label('Dpartamento Destino')
                    ->options(function ($record) {
                        return State::query()
                            ->where(function ($q) use ($record) {
                                $q->whereHas('country', fn($qq) => $qq->where('name', 'Paraguay'));

                                if ($record?->destination_department_id) {
                                    $q->orWhere('id', $record->destination_department_id);
                                }
                            })
                            ->orderBy('name')
                            ->pluck('name', 'id')
                            ->toArray();
                    })
                    ->required()
                    ->searchable(),
                Select::make('travel_reason_id')
                    ->relationship('travelReason', 'description')
                    ->searchable()
                    ->preload()
                    ->label('Motivo')
                    ->required()
                    ->rules([
                        fn(Get $get, $record) => Rule::unique('domestic_tourisms', 'travel_reason_id')
                            ->where(
                                fn($q) => $q
                                    ->where('year_id', $get('year_id'))
                                    ->where('month_id', $get('month_id'))
                                    ->where('destination_department_id', $get('destination_department_id'))
                            )
                            ->ignore($record?->id),
                    ])
                    ->validationMessages([
                        'unique' => 'Ya existe un registro para ese Año/Mes/Departamento/Motivo/Región de origen.',
                    ]),
                TextInput::make('tourist_quantity')
                    ->label('Cantidad de Turistas')
                    ->required()
                    ->numeric()
                    ->minValue(0),
                TextInput::make('total_spend')
                    ->label('Gasto total')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->default(0.0),
                TextInput::make('average_stay')
                    ->label('Estadía promedio')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->default(0.0),
            ]);
    }
}
