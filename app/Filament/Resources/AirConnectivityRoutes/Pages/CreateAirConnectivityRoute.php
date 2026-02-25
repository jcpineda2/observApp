<?php

namespace App\Filament\Resources\AirConnectivityRoutes\Pages;

use App\Filament\Resources\AirConnectivityRoutes\AirConnectivityRouteResource;
use Filament\Resources\Pages\CreateRecord;

class CreateAirConnectivityRoute extends CreateRecord
{
    protected static string $resource = AirConnectivityRouteResource::class;

    protected function getRedirectUrl(): string
    {
        // Redirige al listado después de crear
        return $this->getResource()::getUrl('index');
    }
}
