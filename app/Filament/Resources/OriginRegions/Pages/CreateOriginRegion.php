<?php

namespace App\Filament\Resources\OriginRegions\Pages;

use App\Filament\Resources\OriginRegions\OriginRegionResource;
use Filament\Resources\Pages\CreateRecord;

class CreateOriginRegion extends CreateRecord
{
    protected static string $resource = OriginRegionResource::class;


    protected function getRedirectUrl(): string
    {
        // Redirige al listado después de crear
        return $this->getResource()::getUrl('index');
    }
}
