<?php

namespace App\Filament\Resources\InboundArrivalByMonths\Pages;

use App\Filament\Resources\InboundArrivalByMonths\InboundArrivalByMonthResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditInboundArrivalByMonth extends EditRecord
{
    protected static string $resource = InboundArrivalByMonthResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
