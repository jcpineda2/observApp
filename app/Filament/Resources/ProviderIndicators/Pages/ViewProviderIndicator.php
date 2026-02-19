<?php

namespace App\Filament\Resources\ProviderIndicators\Pages;

use App\Filament\Resources\ProviderIndicators\ProviderIndicatorResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewProviderIndicator extends ViewRecord
{
    protected static string $resource = ProviderIndicatorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
