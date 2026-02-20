<?php

namespace App\Filament\Resources\EmploymentDemographics\Schemas;

use App\Enums\Gender;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class EmploymentDemographicForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('tourism_employment_id')
                    ->relationship('employment.serviceSector','description')
                    ->label('Rubro')
                    ->required(),
                Select::make('gender')
                    ->options(Gender::class)
                    ->label('Género')
                    ->required(),
                TextInput::make('age_range')
                    ->label('Rango de edades')
                    ->required(),
                TextInput::make('people_count')
                    ->label('Cantidad de personas')
                    ->required()
                    ->numeric(),
            ]);
    }
}
