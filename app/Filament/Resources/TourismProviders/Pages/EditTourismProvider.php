<?php

namespace App\Filament\Resources\TourismProviders\Pages;

use App\Filament\Resources\TourismProviders\TourismProviderResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditTourismProvider extends EditRecord
{
    protected static string $resource = TourismProviderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
