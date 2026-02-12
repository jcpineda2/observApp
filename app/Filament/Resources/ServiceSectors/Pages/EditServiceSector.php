<?php

namespace App\Filament\Resources\ServiceSectors\Pages;

use App\Filament\Resources\ServiceSectors\ServiceSectorResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditServiceSector extends EditRecord
{
    protected static string $resource = ServiceSectorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
