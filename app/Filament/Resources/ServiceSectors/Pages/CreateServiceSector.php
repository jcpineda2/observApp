<?php

namespace App\Filament\Resources\ServiceSectors\Pages;

use App\Filament\Resources\ServiceSectors\ServiceSectorResource;
use Filament\Resources\Pages\CreateRecord;

class CreateServiceSector extends CreateRecord
{
    protected static string $resource = ServiceSectorResource::class;

    protected function getRedirectUrl(): string
    {
        // Redirige al listado después de crear
        return $this->getResource()::getUrl('index');
    }
}
