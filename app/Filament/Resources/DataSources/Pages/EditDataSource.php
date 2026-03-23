<?php

namespace App\Filament\Resources\DataSources\Pages;

use App\Filament\Resources\DataSources\DataSourceResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditDataSource extends EditRecord
{
    protected static string $resource = DataSourceResource::class;

    protected function getHeaderActions(): array
    {
        return [
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
