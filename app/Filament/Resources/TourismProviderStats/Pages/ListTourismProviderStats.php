<?php

namespace App\Filament\Resources\TourismProviderStats\Pages;

use App\Filament\Resources\TourismProviderStats\TourismProviderStatResource;
use App\Filament\Widgets\TourismProviderStatsOverview;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTourismProviderStats extends ListRecords
{
    protected static string $resource = TourismProviderStatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            TourismProviderStatsOverview::class,
        ];
    }
}
