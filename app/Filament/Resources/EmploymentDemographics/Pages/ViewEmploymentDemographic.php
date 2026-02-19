<?php

namespace App\Filament\Resources\EmploymentDemographics\Pages;

use App\Filament\Resources\EmploymentDemographics\EmploymentDemographicResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewEmploymentDemographic extends ViewRecord
{
    protected static string $resource = EmploymentDemographicResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
