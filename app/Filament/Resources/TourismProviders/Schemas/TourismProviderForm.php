<?php

namespace App\Filament\Resources\TourismProviders\Schemas;

use App\Enums\Status;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class TourismProviderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('service_sector_id')
                    ->relationship('serviceSector', 'description')
                    ->label('Prestador Turístico')
                    ->required(),
                Select::make('state_id')
                    ->relationship('department', 'name')
                    ->label('Departamento')
                    ->required(),
                DatePicker::make('registration_date')
                    ->label('Fecha de registro'),
                Select::make('status')
                    ->options(Status::class)
                    ->label('Estado')
                    ->default('active')
                    ->required(),
            ]);
    }
}
