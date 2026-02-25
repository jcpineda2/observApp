<?php

namespace App\Filament\Resources\TravelReasons\Pages;

use App\Filament\Resources\TravelReasons\TravelReasonResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTravelReason extends CreateRecord
{
    protected static string $resource = TravelReasonResource::class;

    protected function getRedirectUrl(): string
    {
        // Redirige al listado después de crear
        return $this->getResource()::getUrl('index');
    }
}
