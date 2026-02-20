<?php

namespace App\Filament\Resources\AccommodationCategories\Pages;

use App\Filament\Resources\AccommodationCategories\AccommodationCategoryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAccommodationCategories extends ListRecords
{
    protected static string $resource = AccommodationCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
