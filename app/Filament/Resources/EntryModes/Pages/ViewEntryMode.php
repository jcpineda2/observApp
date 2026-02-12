<?php

namespace App\Filament\Resources\EntryModes\Pages;

use App\Filament\Resources\EntryModes\EntryModeResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewEntryMode extends ViewRecord
{
    protected static string $resource = EntryModeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
