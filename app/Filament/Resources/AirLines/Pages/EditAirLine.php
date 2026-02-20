<?php

namespace App\Filament\Resources\AirLines\Pages;

use App\Filament\Resources\AirLines\AirLineResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditAirLine extends EditRecord
{
    protected static string $resource = AirLineResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
