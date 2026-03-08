<?php

namespace App\Filament\Resources\EmploymentDemographics\Schemas;

use App\Enums\Gender;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Illuminate\Validation\Rule;

class EmploymentDemographicForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('tourism_employment_id')
                    ->relationship('employment.serviceSector', 'description')
                    ->label('Empleo base')
                    ->preload()
                    ->required(),
                Select::make('gender')
                    ->options(Gender::class)
                    ->label('Género')
                    ->required(),
                Select::make('age_range_id')
                    ->label('Rango de edad')
                    ->relationship('ageRange', 'name', modifyQueryUsing: fn($query) => $query->orderBy('sort_order'))
                    ->searchable()
                    ->preload()
                    ->required()
                    ->rules(function (Get $get, $record) {
                        if (! $get('tourism_employment_id') || ! $get('gender') || ! $get('age_range_id')) {
                            return [];
                        }

                        $rule = Rule::unique('employment_demographics', 'age_range_id')
                            ->where(
                                fn($query) => $query
                                    ->where('tourism_employment_id', $get('tourism_employment_id'))
                                    ->where('gender', $get('gender'))
                            );

                        if ($record) {
                            $rule->ignore($record->getKey());
                        }

                        return [$rule];
                    })
                    ->validationMessages([
                        'unique' => 'Ya existe un registro demográfico para el Empleo base, Género y Rango de edad seleccionados.',
                    ]),

                TextInput::make('people_count')
                    ->label('Cantidad de personas')
                    ->required()
                    ->numeric(),
            ]);
    }
}
