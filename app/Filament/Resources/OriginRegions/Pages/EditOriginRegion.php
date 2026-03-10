<?php

namespace App\Filament\Resources\OriginRegions\Pages;

use App\Filament\Resources\OriginRegions\OriginRegionResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditOriginRegion extends EditRecord
{
    protected static string $resource = OriginRegionResource::class;

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
