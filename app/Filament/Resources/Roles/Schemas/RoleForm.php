<?php

namespace App\Filament\Resources\Roles\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class RoleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nombre del rol')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),

                Select::make('permissions')
                    ->label('Permisos')
                    ->multiple()
                    ->relationship('permissions', 'name') // relación de Spatie Role->permissions
                    ->preload()
                    ->searchable(),
            ]);
    }
}
