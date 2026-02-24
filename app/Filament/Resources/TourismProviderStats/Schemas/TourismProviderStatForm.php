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
                        // Tu Month tiene campo 'month' (según tu modelo)
                        ->relationship('month', 'month')
                        ->preload()
                        ->searchable()
                        ->required(),

                    Select::make('service_sector_id')
                        ->label('Rubro (actividad)')
                        // Tu ServiceSector usa 'description' como título (según tu Resource actual)
                        ->relationship('serviceSector', 'description')
                        ->preload()
                        ->searchable()
                        ->required(),

                    Select::make('state_id')
                        ->label('Departamento')
                        // Misma lógica que ya usás en AccommodationForm (solo Paraguay)
                        ->options(function ($record) {
                            $q = State::query()->orderBy('name')
                                ->whereHas('country', fn($qq) => $qq->where('name', 'Paraguay'));

                            if ($record?->state_id) {
                                $q->orWhere('id', $record->state_id);
                            }

                            return $q->pluck('name', 'id')->toArray();
                        })
                        ->searchable()
                        ->required()
                        // Regla clave: evita duplicados antes del SQL
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
                        ->minValue(0)
                        ->default(0)
                        ->required(),

                    TextInput::make('registrations')
                        ->label('Altas (mes)')
                        ->numeric()
                        ->minValue(0)
                        ->default(0)
                        ->required(),

                    TextInput::make('cancellations')
                        ->label('Bajas (mes)')
                        ->numeric()
                        ->minValue(0)
                        ->default(0)
                        ->required(),

                    TextInput::make('formalized_total')
                        ->label('Formalizados (total)')
                        ->numeric()
                        ->minValue(0)
                        ->default(0)
                        ->required(),
                ]),
        ]);
    }
}
