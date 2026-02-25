<?php

namespace App\Filament\Resources\TourismProviderStats\Pages;

use App\Filament\Resources\TourismProviderStats\TourismProviderStatResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTourismProviderStat extends EditRecord
{
    protected static string $resource = TourismProviderStatResource::class;

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
