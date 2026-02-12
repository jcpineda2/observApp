<?php

namespace App\Filament\Resources\TravelReasons\Pages;

use App\Filament\Resources\TravelReasons\TravelReasonResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditTravelReason extends EditRecord
{
    protected static string $resource = TravelReasonResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
