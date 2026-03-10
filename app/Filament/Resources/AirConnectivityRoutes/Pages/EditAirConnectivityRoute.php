<?php

namespace App\Filament\Resources\AirConnectivityRoutes\Pages;

use App\Filament\Resources\AirConnectivityRoutes\AirConnectivityRouteResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditAirConnectivityRoute extends EditRecord
{
    protected static string $resource = AirConnectivityRouteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        // Redirige al listado después de crear
        return $this->getResource()::getUrl('index');
    }
}
