<?php

namespace App\Filament\Resources\ConnectivityIndicators\Pages;

use App\Filament\Resources\ConnectivityIndicators\ConnectivityIndicatorResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditConnectivityIndicator extends EditRecord
{
    protected static string $resource = ConnectivityIndicatorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
