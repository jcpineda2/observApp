<?php

namespace App\Filament\Resources\DataSourceRuns\Pages;

use App\Filament\Resources\DataSourceRuns\DataSourceRunResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDataSourceRuns extends ListRecords
{
    protected static string $resource = DataSourceRunResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
