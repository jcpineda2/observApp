<?php

namespace App\Filament\Resources\AccommodationPerformances\Pages;

use App\Filament\Resources\AccommodationPerformances\AccommodationPerformanceResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAccommodationPerformances extends ListRecords
{
    protected static string $resource = AccommodationPerformanceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
