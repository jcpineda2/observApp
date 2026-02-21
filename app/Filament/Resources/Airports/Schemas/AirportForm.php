<?php

namespace App\Filament\Resources\Airports\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;

class AirportForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nombre')
                    ->required(),
                Select::make('country_id')
                    ->relationship('country', 'name')
                    ->label('País')
                    ->required()
                    ->preload()
                    ->live()
                    ->afterStateUpdated(fn(Set $set) => $set('city_id', null)),
                Select::make('city_id')
                    ->label('Ciudad')
                    ->relationship(
                        name: 'city',
                        titleAttribute: 'name',
                        // Aquí aplicamos el filtro dinámico directamente en la relación
                        modifyQueryUsing: fn(Builder $query, Get $get) => $query
                            ->where('country_id', $get('country_id'))
                    )
                    ->searchable()
                    ->preload()
                    ->disabled(fn(Get $get): bool => empty($get('country_id')))
                    ->required(),
            ]);
    }
}
