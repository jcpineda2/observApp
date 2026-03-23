<?php

namespace App\Filament\Resources\DataSources\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class DataSourceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nombre')
                    ->required(),
                TextInput::make('code')
                    ->label('Código')
                    ->required(),
                TextInput::make('type')
                    ->label('Tipo')
                    ->required(),
                Textarea::make('description')
                    ->label('Descripción')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('owner')
                    ->label('Dueño')
                    ->default(null),
                Toggle::make('is_active')
                    ->label('Activo')
                    ->required(),
            ]);
    }
}
