<?php

namespace App\Filament\Resources\InboundTourisms\Pages;

use App\Filament\Resources\InboundTourisms\InboundTourismResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListInboundTourisms extends ListRecords
{
    protected static string $resource = InboundTourismResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
