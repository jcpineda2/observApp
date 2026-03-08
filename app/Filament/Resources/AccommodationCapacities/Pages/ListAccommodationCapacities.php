<?php

namespace App\Filament\Resources\AccommodationCapacities\Pages;

use App\Filament\Resources\AccommodationCapacities\AccommodationCapacityResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAccommodationCapacities extends ListRecords
{
    protected static string $resource = AccommodationCapacityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
