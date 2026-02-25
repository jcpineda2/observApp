<?php

namespace App\Filament\Resources\AccommodationPerformances\Pages;

use App\Filament\Resources\AccommodationPerformances\AccommodationPerformanceResource;
use Filament\Resources\Pages\CreateRecord;

class CreateAccommodationPerformance extends CreateRecord
{
    protected static string $resource = AccommodationPerformanceResource::class;

    protected function getRedirectUrl(): string
    {
        // Redirige al listado después de crear
        return $this->getResource()::getUrl('index');
    }
}
