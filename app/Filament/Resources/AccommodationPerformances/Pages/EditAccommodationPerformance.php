<?php

namespace App\Filament\Resources\AccommodationPerformances\Pages;

use App\Filament\Resources\AccommodationPerformances\AccommodationPerformanceResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditAccommodationPerformance extends EditRecord
{
    protected static string $resource = AccommodationPerformanceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
