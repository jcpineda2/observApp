<?php

namespace App\Filament\Resources\IndicatorConstants\Pages;

use App\Filament\Resources\IndicatorConstants\IndicatorConstantResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListIndicatorConstants extends ListRecords
{
    protected static string $resource = IndicatorConstantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
