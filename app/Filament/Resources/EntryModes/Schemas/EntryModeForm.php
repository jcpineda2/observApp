<?php

namespace App\Filament\Resources\EntryModes\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class EntryModeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('description')
                    ->label('Descripción')
                    ->unique(ignoreRecord: true)
                    ->validationMessages([
                        'unique' => 'Ya existe un modo de entrada con este nombre.'])
                    ->required(),
            ]);
    }
}
