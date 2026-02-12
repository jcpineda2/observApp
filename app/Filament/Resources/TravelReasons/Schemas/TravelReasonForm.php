<?php

namespace App\Filament\Resources\TravelReasons\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class TravelReasonForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('description')
                    ->required(),
            ]);
    }
}
