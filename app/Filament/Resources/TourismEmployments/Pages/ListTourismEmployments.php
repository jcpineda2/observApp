<?php

namespace App\Filament\Resources\TourismEmployments\Pages;

use App\Filament\Resources\TourismEmployments\TourismEmploymentResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTourismEmployments extends ListRecords
{
    protected static string $resource = TourismEmploymentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
