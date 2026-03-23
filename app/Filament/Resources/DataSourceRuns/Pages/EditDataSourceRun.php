<?php

namespace App\Filament\Resources\DataSourceRuns\Pages;

use App\Filament\Resources\DataSourceRuns\DataSourceRunResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditDataSourceRun extends EditRecord
{
    protected static string $resource = DataSourceRunResource::class;

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
