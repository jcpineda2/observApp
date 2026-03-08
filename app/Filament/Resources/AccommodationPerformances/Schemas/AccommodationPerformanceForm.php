<?php

namespace App\Filament\Resources\AccommodationPerformances\Schemas;

use App\Enums\Season;
use Filament\Actions\SelectAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\Rule;

class AccommodationPerformanceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('year_id')
                    ->relationship(
                        name: 'year',
                        titleAttribute: 'year',
                        modifyQueryUsing: fn(Builder $query) => $query->orderBy('year', 'desc')
                    )
                    ->preload()
                    ->searchable()
                    ->label('Año')
                    ->required(),
                Select::make('month_id')
                    ->relationship(
                        name: 'month',
                        titleAttribute: 'month',
                        modifyQueryUsing: fn(Builder $query) => $query->orderBy('month_number', 'asc')
                    )
                    ->preload()
                    ->label('Mes')
                    ->required()
                   ->rules(function (Get $get, $record) {
                        if (! $get('year_id') || ! $get('month_id') || ! $get('state_id')) {
                            return [];
                        }

                        $rule = Rule::unique('accommodation_performances', 'month_id')
                            ->where(fn ($query) => $query
                                ->where('year_id', $get('year_id'))
                                ->where('state_id', $get('state_id'))
                            );

                        if ($record) {
                            $rule->ignore($record->getKey());
                        }

                        return [$rule];
                    })
                    ->validationMessages([
                        'unique' => 'Ya existe una ocupación registrada para el Año, Mes y Departamento seleccionados.',
                    ]),

                Select::make('state_id')
                    ->label('Departamento')
                    ->relationship(
                        name: 'state',
                        titleAttribute: 'name',
                        modifyQueryUsing: fn(Builder $query) => $query
                            ->whereHas('country', function ($q) {
                                $q->where('name', 'Paraguay');
                            })
                    )
                    ->searchable()
                    ->preload()
                    ->required(),

                TextInput::make('occupancy_rate')
                    ->label('Ocupación (%)')
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(100)
                    ->step('0.01')
                    ->required(),

                Select::make('season')
                    ->label('Temporada')
                    ->options(Season::class)
                    ->nullable()
                    ->searchable()
            ]);
    }
}
