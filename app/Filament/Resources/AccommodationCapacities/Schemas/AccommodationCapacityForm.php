<?php

namespace App\Filament\Resources\AccommodationCapacities\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\Rule;

class AccommodationCapacityForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('accommodation_category_id')
                    ->label('Categoría')
                    ->relationship('category', 'category', modifyQueryUsing: fn($query) => $query->orderBy('category'))
                    ->searchable()
                    ->preload()
                    ->required(),

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
                    ->required()
                    ->rules(function (Get $get, $record) {
                        if (! $get('accommodation_category_id') || ! $get('state_id')) {
                            return [];
                        }

                        $rule = Rule::unique('accommodation_capacities', 'state_id')
                            ->where(
                                fn($query) => $query
                                    ->where('accommodation_category_id', $get('accommodation_category_id'))
                            );

                        if ($record) {
                            $rule->ignore($record->getKey());
                        }

                        return [$rule];
                    })
                    ->validationMessages([
                        'unique' => 'Ya existe una capacidad registrada para la Categoría y el Departamento seleccionados.',
                    ]),

                TextInput::make('establishments_count')
                    ->label('Cantidad de establecimientos')
                    ->numeric()
                    ->minValue(0)
                    ->required(),

                TextInput::make('rooms_count')
                    ->label('Cantidad de habitaciones')
                    ->numeric()
                    ->minValue(0)
                    ->required(),

                TextInput::make('beds_count')
                    ->label('Cantidad de camas')
                    ->numeric()
                    ->minValue(0)
                    ->required(),
            ]);
    }
}
