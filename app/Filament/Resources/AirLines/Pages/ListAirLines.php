<?php

namespace App\Filament\Resources\AirLines\Pages;

use App\Filament\Resources\AirLines\AirLineResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAirLines extends ListRecords
{
    protected static string $resource = AirLineResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
