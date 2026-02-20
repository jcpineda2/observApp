<?php

namespace App\Filament\Resources\DomesticTourisms\Pages;

use App\Filament\Resources\DomesticTourisms\DomesticTourismResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewDomesticTourism extends ViewRecord
{
    protected static string $resource = DomesticTourismResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
