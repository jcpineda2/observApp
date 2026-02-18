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
                    ->relationship('serviceSector', 'id')
                    ->required(),
                TextInput::make('state_id')
                    ->required()
                    ->numeric(),
                DatePicker::make('registration_date'),
                Select::make('status')
                    ->options(Status::class)
                    ->default('active')
                    ->required(),
            ]);
    }
}
