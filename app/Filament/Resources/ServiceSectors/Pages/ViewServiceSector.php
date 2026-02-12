<?php

namespace App\Filament\Resources\ServiceSectors\Pages;

use App\Filament\Resources\ServiceSectors\ServiceSectorResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewServiceSector extends ViewRecord
{
    protected static string $resource = ServiceSectorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
