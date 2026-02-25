<?php

namespace App\Filament\Resources\AccommodationCategories\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class AccommodationCategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('category')
                    ->label('Categoria')
                    ->required()
                    ->unique()
                    ->validationMessages([
                        'unique' => 'Ya existe una categoría con ese nombre.',
                    ]),
            ]);
    }
}
