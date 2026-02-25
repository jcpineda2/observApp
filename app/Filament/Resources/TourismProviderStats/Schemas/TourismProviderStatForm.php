<?php

namespace App\Filament\Resources\TourismProviderStats\Schemas;

use App\Models\State;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Validation\Rule;

class TourismProviderStatForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Periodo y segmentación')
                ->columns(1)
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

                    Select::make('service_sector_id')
                        ->label('Rubro (actividad)')
                        ->relationship('serviceSector', 'description')
                        ->preload()
                        ->searchable()
                        ->required(),

                    Select::make('state_id')
                        ->label('Departamento')
                        ->searchable()
                        ->options(function ($record) {
                            $q = State::query()
                                ->where(function ($qq) use ($record) {
                                    $qq->whereHas('country', fn($c) => $c->where('name', 'Paraguay'));

                                    if ($record?->state_id) {
                                        $qq->orWhere('id', $record->state_id);
                                    }
                                })
                                ->orderBy('name');

                            return $q->pluck('name', 'id')->toArray();
                        })
                        ->preload()
                        ->searchable()
                        ->required()
                        ->rules([
                            fn($get, $record) => Rule::unique('tourism_provider_stats', 'state_id')
                                ->where(
                                    fn($q) => $q
                                        ->where('year_id', $get('year_id'))
                                        ->where('month_id', $get('month_id'))
                                        ->where('service_sector_id', $get('service_sector_id'))
                                )
                                ->ignore($record?->id),
                        ])
                ]),

            Section::make('Indicadores')
                ->columns(1)
                ->components([
                    TextInput::make('total_registered')
                        ->label('Total registrados')
                        ->numeric()
                        ->live()
                        ->minValue(0)
                        ->default(0)
                        ->required(),

                    TextInput::make('registrations')
                        ->label('Altas (mes)')
                        ->numeric()
                        ->minValue(0)
                        ->default(0)
                        ->live()
                        ->required(),

                    TextInput::make('cancellations')
                        ->label('Bajas (mes)')
                        ->numeric()
                        ->live()
                        ->minValue(0)
                        ->default(0)
                        ->required(),

                    TextInput::make('formalized_total')
                        ->label('Formalizados (total)')
                        ->numeric()
                        ->minValue(0)
                        ->disabled()
                        ->dehydrated()
                        ->live()
                        ->afterStateHydrated(function ($component, $state, $get) {
                            $component->state(
                                ($get('total_registered') ?? 0)
                                    + ($get('registrations') ?? 0)
                                    - ($get('cancellations') ?? 0)
                            );
                        }),
                ]),
        ]);
    }
}
