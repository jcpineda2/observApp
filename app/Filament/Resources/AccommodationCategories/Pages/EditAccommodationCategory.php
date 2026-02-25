<?php

namespace App\Filament\Resources\AccommodationCategories\Pages;

use App\Filament\Resources\AccommodationCategories\AccommodationCategoryResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditAccommodationCategory extends EditRecord
{
    protected static string $resource = AccommodationCategoryResource::class;

    protected function getRedirectUrl(): string
    {
        // Redirige al listado después de crear
        return $this->getResource()::getUrl('index');
    }

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
