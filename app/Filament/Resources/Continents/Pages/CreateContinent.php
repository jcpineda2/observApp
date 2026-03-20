<?php

namespace App\Filament\Resources\Continents\Pages;

use App\Filament\Resources\Continents\ContinentResource;
use Filament\Resources\Pages\CreateRecord;

class CreateContinent extends CreateRecord
{
    protected static string $resource = ContinentResource::class;

    protected function getRedirectUrl(): string
    {
        // Redirige al listado después de crear
        return $this->getResource()::getUrl('index');
    }
}
