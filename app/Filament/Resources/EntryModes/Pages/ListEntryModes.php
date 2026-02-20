<?php

namespace App\Filament\Resources\EntryModes\Pages;

use App\Filament\Resources\EntryModes\EntryModeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListEntryModes extends ListRecords
{
    protected static string $resource = EntryModeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
