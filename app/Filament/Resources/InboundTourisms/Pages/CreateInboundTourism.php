<?php

namespace App\Filament\Resources\InboundTourisms\Pages;

use App\Filament\Resources\InboundTourisms\InboundTourismResource;
use Filament\Resources\Pages\CreateRecord;

class CreateInboundTourism extends CreateRecord
{
    protected static string $resource = InboundTourismResource::class;

    protected function getRedirectUrl(): string
    {
        // Redirige al listado después de crear
        return $this->getResource()::getUrl('index');
    }
}
