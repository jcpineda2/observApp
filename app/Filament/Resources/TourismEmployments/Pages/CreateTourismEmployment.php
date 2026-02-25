<?php

namespace App\Filament\Resources\TourismEmployments\Pages;

use App\Filament\Resources\TourismEmployments\TourismEmploymentResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTourismEmployment extends CreateRecord
{
    protected static string $resource = TourismEmploymentResource::class;

    protected function getRedirectUrl(): string
    {
        // Redirige al listado después de crear
        return $this->getResource()::getUrl('index');
    }
}
