<?php

namespace App\Filament\Resources\ConnectivityIndicators\Pages;

use App\Filament\Resources\ConnectivityIndicators\ConnectivityIndicatorResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewConnectivityIndicator extends ViewRecord
{
    protected static string $resource = ConnectivityIndicatorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
