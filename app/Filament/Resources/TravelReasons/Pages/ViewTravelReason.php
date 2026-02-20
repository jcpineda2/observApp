<?php

namespace App\Filament\Resources\TravelReasons\Pages;

use App\Filament\Resources\TravelReasons\TravelReasonResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewTravelReason extends ViewRecord
{
    protected static string $resource = TravelReasonResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
