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
            DeleteAction::make()
                ->visible(fn(): bool => static::getResource()::canDelete($this->record)),

        ];
    }

    protected function getRedirectUrl(): string
    {
        // Redirige al listado después de crear
        return $this->getResource()::getUrl('index');
    }
}
