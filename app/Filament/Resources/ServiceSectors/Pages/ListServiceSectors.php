<?php

namespace App\Filament\Resources\ServiceSectors\Pages;

use App\Filament\Resources\ServiceSectors\ServiceSectorResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListServiceSectors extends ListRecords
{
    protected static string $resource = ServiceSectorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
