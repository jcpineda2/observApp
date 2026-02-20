<?php

namespace App\Filament\Resources\TourismEmployments\Pages;

use App\Filament\Resources\TourismEmployments\TourismEmploymentResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewTourismEmployment extends ViewRecord
{
    protected static string $resource = TourismEmploymentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
