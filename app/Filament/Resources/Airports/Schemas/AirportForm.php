<?php

namespace App\Filament\Resources\Airports\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class AirportForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('country_id')
                    ->required()
                    ->numeric(),
                TextInput::make('city_id')
                    ->required()
                    ->numeric(),
            ]);
    }
}
