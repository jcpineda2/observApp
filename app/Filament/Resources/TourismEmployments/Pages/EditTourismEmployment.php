<?php

namespace App\Filament\Resources\TourismEmployments\Pages;

use App\Filament\Resources\TourismEmployments\TourismEmploymentResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditTourismEmployment extends EditRecord
{
    protected static string $resource = TourismEmploymentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
