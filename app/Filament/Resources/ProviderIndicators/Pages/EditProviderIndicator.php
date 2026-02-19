<?php

namespace App\Filament\Resources\ProviderIndicators\Pages;

use App\Filament\Resources\ProviderIndicators\ProviderIndicatorResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditProviderIndicator extends EditRecord
{
    protected static string $resource = ProviderIndicatorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
