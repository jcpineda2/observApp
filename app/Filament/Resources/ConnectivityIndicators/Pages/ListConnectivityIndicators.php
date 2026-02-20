<?php

namespace App\Filament\Resources\ConnectivityIndicators\Pages;

use App\Filament\Resources\ConnectivityIndicators\ConnectivityIndicatorResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListConnectivityIndicators extends ListRecords
{
    protected static string $resource = ConnectivityIndicatorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
