<?php

namespace App\Filament\Resources\DomesticTourisms\Pages;

use App\Filament\Resources\DomesticTourisms\DomesticTourismResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDomesticTourisms extends ListRecords
{
    protected static string $resource = DomesticTourismResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
