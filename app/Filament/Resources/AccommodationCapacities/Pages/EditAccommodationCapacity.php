<?php

namespace App\Filament\Resources\AccommodationCapacities\Pages;

use App\Filament\Resources\AccommodationCapacities\AccommodationCapacityResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditAccommodationCapacity extends EditRecord
{
    protected static string $resource = AccommodationCapacityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        // Redirige al listado después de crear
        return $this->getResource()::getUrl('index');
    }
}
