<?php

namespace App\Filament\Resources\Accommodations\Schemas;

use App\Models\State;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\Rule;

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
                        $q = State::query()
                            ->where(function ($qq) use ($record) {
                                $qq->whereHas('country', fn($c) => $c->where('name', 'Paraguay'));

                                if ($record?->state_id) {
                                    $qq->orWhere('id', $record->state_id);
                                }
                            })
                            ->orderBy('name');

                        return $q->pluck('name', 'id')->toArray();
                    })
                    ->rules([
                        fn(Get $get, $record) => Rule::unique('accommodations', 'state_id')
                            ->where(fn($q) => $q->where('accommodation_category_id', $get('accommodation_category_id')))
                            ->ignore($record?->id),
                    ])
                    ->validationMessages([
                        'unique' => 'Ya existe capacidad instalada para ese Departamento y Categoría.',
                    ])
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
