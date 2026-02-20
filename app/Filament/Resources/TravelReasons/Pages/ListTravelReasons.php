<?php

namespace App\Filament\Resources\TravelReasons\Pages;

use App\Filament\Resources\TravelReasons\TravelReasonResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTravelReasons extends ListRecords
{
    protected static string $resource = TravelReasonResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
