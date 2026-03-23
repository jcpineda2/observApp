<?php

namespace App\Filament\Resources\DataSourceRuns\Pages;

use App\Filament\Resources\DataSourceRuns\DataSourceRunResource;
use Filament\Resources\Pages\CreateRecord;

class CreateDataSourceRun extends CreateRecord
{
    protected static string $resource = DataSourceRunResource::class;

    protected function getRedirectUrl(): string
    {
        // Redirige al listado después de crear
        return $this->getResource()::getUrl('index');
    }
}
