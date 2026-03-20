<?php

namespace App\Filament\Resources\Continents\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ContinentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('continent')
                    ->label('Continentes')
                    ->required(),
            ]);
    }
}
