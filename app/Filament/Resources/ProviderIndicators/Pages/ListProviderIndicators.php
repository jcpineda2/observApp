<?php

namespace App\Filament\Resources\ProviderIndicators\Pages;

use App\Filament\Resources\ProviderIndicators\ProviderIndicatorResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListProviderIndicators extends ListRecords
{
    protected static string $resource = ProviderIndicatorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
