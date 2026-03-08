<?php

namespace App\Filament\Resources\IndicatorConstants\Pages;

use App\Filament\Resources\IndicatorConstants\IndicatorConstantResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditIndicatorConstant extends EditRecord
{
    protected static string $resource = IndicatorConstantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
