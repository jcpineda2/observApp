<?php

namespace App\Filament\Resources\DataSources\Pages;

use App\Filament\Resources\DataSources\DataSourceResource;
use Filament\Resources\Pages\CreateRecord;

class CreateDataSource extends CreateRecord
{
    protected static string $resource = DataSourceResource::class;

    protected function getRedirectUrl(): string
    {
        // Redirige al listado después de crear
        return $this->getResource()::getUrl('index');
    }
}
