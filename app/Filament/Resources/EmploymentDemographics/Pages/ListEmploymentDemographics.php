<?php

namespace App\Filament\Resources\EmploymentDemographics\Pages;

use App\Filament\Resources\EmploymentDemographics\EmploymentDemographicResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListEmploymentDemographics extends ListRecords
{
    protected static string $resource = EmploymentDemographicResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
