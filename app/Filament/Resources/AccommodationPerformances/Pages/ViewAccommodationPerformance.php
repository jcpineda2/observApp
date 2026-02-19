<?php

namespace App\Filament\Resources\AccommodationPerformances\Pages;

use App\Filament\Resources\AccommodationPerformances\AccommodationPerformanceResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewAccommodationPerformance extends ViewRecord
{
    protected static string $resource = AccommodationPerformanceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
