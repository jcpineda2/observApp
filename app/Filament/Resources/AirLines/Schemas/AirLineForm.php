<?php

namespace App\Filament\Resources\AirLines\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class AirLineForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
            ]);
    }
}
