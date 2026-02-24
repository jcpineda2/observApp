<?php

namespace App\Filament\Resources\AirConnectivityRoutes\Pages;

use App\Filament\Resources\AirConnectivityRoutes\AirConnectivityRouteResource;
use App\Filament\Widgets\AirConnectivityOverview;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAirConnectivityRoutes extends ListRecords
{
    protected static string $resource = AirConnectivityRouteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            AirConnectivityOverview::class,
        ];
    }
}
