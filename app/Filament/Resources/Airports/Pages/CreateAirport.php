<?php

namespace App\Filament\Resources\Airports\Pages;

use App\Filament\Resources\Airports\AirportResource;
use App\Models\Country;
use Filament\Resources\Pages\CreateRecord;

class CreateAirport extends CreateRecord
{
    protected static string $resource = AirportResource::class;

    protected function getRedirectUrl(): string
    {
        // Redirige al listado después de crear
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $countryId =Country::where('name','like','%Paraguay%')->value('id');
        if($data['country_id'] === $countryId){
            $data['scope'] = "Nacional";
        }
        $data['is_operational'] = true;

        return $data;
    }
}
