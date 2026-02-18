<?php

namespace App\Filament\Resources\Accommodations\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class AccommodationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('accommodation_category_id')
                    ->required()
                    ->numeric(),
                TextInput::make('state_id')
                    ->required()
                    ->numeric(),
                TextInput::make('establishments_count')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('rooms_count')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('beds_count')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }
}
