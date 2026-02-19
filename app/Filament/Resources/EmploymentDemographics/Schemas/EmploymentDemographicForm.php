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
                TextInput::make('tourism_employment_id')
                    ->required()
                    ->numeric(),
                Select::make('gender')
                    ->options(Gender::class)
                    ->required(),
                TextInput::make('age_range')
                    ->required(),
                TextInput::make('people_count')
                    ->required()
                    ->numeric(),
            ]);
    }
}
