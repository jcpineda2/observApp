<?php

namespace App\Filament\Resources\DomesticTourisms\Pages;

use App\Filament\Resources\DomesticTourisms\DomesticTourismResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditDomesticTourism extends EditRecord
{
    protected static string $resource = DomesticTourismResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
