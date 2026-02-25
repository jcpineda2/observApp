<?php

namespace App\Filament\Resources\TourismProviderStats\Pages;

use App\Filament\Resources\TourismProviderStats\TourismProviderStatResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTourismProviderStat extends CreateRecord
{
    protected static string $resource = TourismProviderStatResource::class;

    protected function getRedirectUrl(): string
    {
        // Redirige al listado después de crear
        return $this->getResource()::getUrl('index');
    }
}
