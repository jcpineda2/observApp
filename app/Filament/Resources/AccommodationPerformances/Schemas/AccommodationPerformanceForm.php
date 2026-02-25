<?php

namespace App\Filament\Resources\AccommodationPerformances\Schemas;

use Filament\Actions\SelectAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Illuminate\Validation\Rule;

class AccommodationPerformanceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('accommodation_id')
                    ->relationship('accommodation', 'id')
                    ->getOptionLabelFromRecordUsing(fn($record) => "{$record->state?->name} - {$record->category?->category}")
                    ->label('Alojamiento (Depto - Categoría)')
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('year_id')
                    ->relationship('year', 'year')
                    ->preload()
                    ->label('Año')
                    ->required(),
                Select::make('month_id')
                    ->relationship('month', 'month')
                    ->preload()
                    ->label('Mes')
                    ->required()
                    ->rules(function (Get $get, $record) {
                        // Evita validar mientras el usuario aún no seleccionó todo
                        if (! $get('accommodation_id') || ! $get('year_id') || ! $get('month_id')) {
                            return [];
                        }

                        $rule = Rule::unique('accommodation_performances', 'month_id')
                            ->where(
                                fn($q) => $q
                                    ->where('accommodation_id', $get('accommodation_id'))
                                    ->where('year_id', $get('year_id'))
                            );

                        if ($record) {
                            $rule->ignore($record->getKey());
                        }

                        return [$rule];
                    })
                    ->validationMessages([
                        'unique' => 'Ya existe un desempeño para ese Alojamiento/Año/Mes.',
                    ]),
                TextInput::make('occupancy_rate')
                    ->label('Tasa de ocupación (%)')
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(100)
                    ->required(),
                Select::make('season')
                    ->label('Temporada')
                    ->options([
                        'alta' => 'Alta',
                        'baja' => 'Baja',
                    ])
                    ->nullable()
                    ->searchable()
            ]);
    }
}
