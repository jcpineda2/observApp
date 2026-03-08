<?php

namespace App\Filament\Resources\AgeRanges\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class AgeRangeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nombre')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),

                TextInput::make('sort_order')
                    ->label('Orden')
                    ->numeric()
                    ->minValue(0)
                    ->required(),
            ]);
    }
}
