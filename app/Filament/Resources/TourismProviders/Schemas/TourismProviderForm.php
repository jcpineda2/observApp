<?php

namespace App\Filament\Resources\TourismProviders\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class TourismProviderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('service_sector_id')
                    ->required()
                    ->numeric(),
                TextInput::make('state_id')
                    ->required()
                    ->numeric(),
                DatePicker::make('registration_date'),
                TextInput::make('status')
                    ->required()
                    ->default('active'),
            ]);
    }
}
