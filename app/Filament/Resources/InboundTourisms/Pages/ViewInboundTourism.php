<?php

namespace App\Filament\Resources\InboundTourisms\Pages;

use App\Filament\Resources\InboundTourisms\InboundTourismResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewInboundTourism extends ViewRecord
{
    protected static string $resource = InboundTourismResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
