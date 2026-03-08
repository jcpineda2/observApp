<?php

namespace App\Filament\Resources\OriginRegions\Pages;

use App\Filament\Resources\OriginRegions\OriginRegionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListOriginRegions extends ListRecords
{
    protected static string $resource = OriginRegionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
