<?php

namespace App\Filament\Resources\InboundTourisms\Pages;

use App\Filament\Resources\InboundTourisms\InboundTourismResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditInboundTourism extends EditRecord
{
    protected static string $resource = InboundTourismResource::class;

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
