<?php

namespace App\Filament\Resources\Accommodations\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;

class AccommodationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('accommodation_category_id')
                    ->label('Categoría')
                    ->relationship('category', 'category')
                    ->required()
                    ->preload(),
                Select::make('state_id')
                    ->label('Departamento')
                    ->relationship(
                        name: 'state',
                        titleAttribute: 'name',
                        modifyQueryUsing: fn(Builder $query) => $query
                            ->whereHas('country', fn($q) => $q->where('name', 'Paraguay'))
                    )
                    ->required()
                    ->preload(),
                TextInput::make('establishments_count')
                    ->label('Cantidad de Establecimientos')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('rooms_count')
                    ->label('Cantidad habitaciones')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('beds_count')
                    ->label('Cantidad camas')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }
}
