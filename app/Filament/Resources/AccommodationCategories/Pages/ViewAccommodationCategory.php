<?php

namespace App\Filament\Resources\AccommodationCategories\Pages;

use App\Filament\Resources\AccommodationCategories\AccommodationCategoryResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewAccommodationCategory extends ViewRecord
{
    protected static string $resource = AccommodationCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
