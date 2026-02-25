<?php

namespace App\Filament\Resources\AccommodationCategories\Pages;

use App\Filament\Resources\AccommodationCategories\AccommodationCategoryResource;
use Filament\Resources\Pages\CreateRecord;

class CreateAccommodationCategory extends CreateRecord
{
    protected static string $resource = AccommodationCategoryResource::class;


    //Funcion para redireccionar el listado luego de crear uno nuevo
    protected function getRedirectUrl(): string
    {
        // Redirige al listado después de crear
        return $this->getResource()::getUrl('index');
    }
}
