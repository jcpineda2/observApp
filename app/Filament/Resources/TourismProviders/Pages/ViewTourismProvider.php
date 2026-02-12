<?php

namespace App\Filament\Resources\TourismProviders\Pages;

use App\Filament\Resources\TourismProviders\TourismProviderResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewTourismProvider extends ViewRecord
{
    protected static string $resource = TourismProviderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
