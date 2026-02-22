<?php

namespace App\Filament\Resources\TourismProviders\Schemas;

use App\Enums\Status;
use App\Models\State;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;

class TourismProviderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('service_sector_id')
                    ->relationship('serviceSector', 'description')
                    ->label('Rubro')
                    ->required(),
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
                DatePicker::make('registration_date')
                    ->label('Fecha de registro'),
                Select::make('status')
                    ->options(Status::class)
                    ->label('Estado')
                    ->default('active')
                    ->required(),
            ]);
    }
}
