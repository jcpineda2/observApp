<?php

namespace App\Filament\Resources\TravelReasons;

use App\Filament\Resources\TravelReasons\Pages\CreateTravelReason;
use App\Filament\Resources\TravelReasons\Pages\EditTravelReason;
use App\Filament\Resources\TravelReasons\Pages\ListTravelReasons;
use App\Filament\Resources\TravelReasons\Pages\ViewTravelReason;
use App\Filament\Resources\TravelReasons\Schemas\TravelReasonForm;
use App\Filament\Resources\TravelReasons\Schemas\TravelReasonInfolist;
use App\Filament\Resources\TravelReasons\Tables\TravelReasonsTable;
use App\Models\TravelReason;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TravelReasonResource extends Resource
{
    protected static ?string $model = TravelReason::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'TravelReason'; //rasones de viaje

    public static function form(Schema $schema): Schema
    {
        return TravelReasonForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return TravelReasonInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TravelReasonsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTravelReasons::route('/'),
            'create' => CreateTravelReason::route('/create'),
            'view' => ViewTravelReason::route('/{record}'),
            'edit' => EditTravelReason::route('/{record}/edit'),
        ];
    }
}
