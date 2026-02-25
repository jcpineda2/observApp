<?php

namespace App\Filament\Resources\ServiceSectors\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ServiceSectorForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('description')
                    ->label('Rubros')
                    ->unique()
                    ->validationMessages([
                        'unique' => 'Ya existe un rubro con este nombre.',
                    ])
                    ->required(),
            ]);
    }
}
