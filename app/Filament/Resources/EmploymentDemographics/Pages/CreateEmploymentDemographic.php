<?php

namespace App\Filament\Resources\EmploymentDemographics\Pages;

use App\Filament\Resources\EmploymentDemographics\EmploymentDemographicResource;
use Filament\Resources\Pages\CreateRecord;

class CreateEmploymentDemographic extends CreateRecord
{
    protected static string $resource = EmploymentDemographicResource::class;

    protected function getRedirectUrl(): string
    {
        // Redirige al listado después de crear
        return $this->getResource()::getUrl('index');
    }
}
