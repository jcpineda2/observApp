<?php

namespace App\Filament\Resources\AirLines\Pages;

use App\Filament\Resources\AirLines\AirLineResource;
use Filament\Resources\Pages\CreateRecord;

class CreateAirLine extends CreateRecord
{
    protected static string $resource = AirLineResource::class;

    protected function getRedirectUrl(): string
    {
        // Redirige al listado después de crear
        return $this->getResource()::getUrl('index');
    }
}
