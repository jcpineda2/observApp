<?php

namespace App\Filament\Resources\AgeRanges\Pages;

use App\Filament\Resources\AgeRanges\AgeRangeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAgeRanges extends ListRecords
{
    protected static string $resource = AgeRangeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
