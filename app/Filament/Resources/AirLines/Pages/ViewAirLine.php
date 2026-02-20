<?php

namespace App\Filament\Resources\AirLines\Pages;

use App\Filament\Resources\AirLines\AirLineResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewAirLine extends ViewRecord
{
    protected static string $resource = AirLineResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
