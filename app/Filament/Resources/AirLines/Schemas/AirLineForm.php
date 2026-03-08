<?php

namespace App\Filament\Resources\AirLines\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class AirLineForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Aerolinea')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true)
                    ->validationMessages([
                        'unique' => 'Ya existe una aerolinea con este nombre.'
                    ]),
                Toggle::make('is_active')
                    ->label('Activa')
                    ->default(true)
                    ->required(),
            ]);
    }
}
