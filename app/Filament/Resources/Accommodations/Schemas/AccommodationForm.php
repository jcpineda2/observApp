<?php

namespace App\Filament\Resources\Accommodations\Schemas;

use App\Models\State;
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
                    ->options(function ($record) {
                        $q = State::query()->orderBy('name');

                        // Solo Paraguay
                        $q->whereHas('country', fn($qq) => $qq->where('name', 'Paraguay'));

                        // pero incluir el actual si existe
                        if ($record?->state_id) {
                            $q->orWhere('id', $record->state_id);
                        }

                        return $q->pluck('name', 'id')->toArray();
                    })
                    ->required()
                    ->searchable(),
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
