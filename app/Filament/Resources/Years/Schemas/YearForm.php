<?php

namespace App\Filament\Resources\Years\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class YearForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('year')
                    ->label('Nombre')
                    ->required()
                    ->unique()
                    ->validationMessages([
                        'unique' => 'Ya existe una año con ese nombre.',
                    ])
                    ->numeric(),
            ]);
    }
}
