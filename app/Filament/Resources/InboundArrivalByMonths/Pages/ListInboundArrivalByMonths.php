<?php

namespace App\Filament\Resources\InboundArrivalByMonths\Pages;

use App\Filament\Resources\InboundArrivalByMonths\InboundArrivalByMonthResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListInboundArrivalByMonths extends ListRecords
{
    protected static string $resource = InboundArrivalByMonthResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
