<?php

namespace App\Filament\Resources\TourismEmployments\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Illuminate\Validation\Rule;

class TourismEmploymentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('year_id')
                    ->relationship('year', 'year')
                    ->label('Año')
                    ->required(),
                Select::make('service_sector_id')
                    ->relationship('serviceSector', 'description')
                    ->label('Rubro')
                    ->required()
                    ->rules(function (Get $get, $record) {
                        $rule = Rule::unique('tourism_employments')
                            ->where(
                                fn($q) => $q
                                    ->where('year_id', $get('year_id'))
                                    ->where('service_sector_id', $get('service_sector_id'))
                            );

                        if ($record) {
                            $rule->ignore($record->getKey());
                        }

                        return [$rule];
                    })
                    ->validationMessages([
                        'unique' => 'Ya existe un registro de empleo para ese Año y Sector.',
                    ]),
                TextInput::make('direct_employment')
                    ->label('Empleo directo')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('national_participation')
                    ->label('Participación nacional')
                    ->numeric()
                    ->default(null),
                TextInput::make('interannual_variation')
                    ->label('Variación interanual')
                    ->numeric()
                    ->default(null),
            ]);
    }
}
