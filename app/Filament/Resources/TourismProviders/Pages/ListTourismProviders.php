<?php

namespace App\Filament\Resources\TourismProviders\Pages;

use App\Filament\Resources\TourismProviders\TourismProviderResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTourismProviders extends ListRecords
{
    protected static string $resource = TourismProviderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
