<?php

namespace App\Filament\Resources\AirLines;

use App\Filament\Resources\AirLines\Pages\CreateAirLine;
use App\Filament\Resources\AirLines\Pages\EditAirLine;
use App\Filament\Resources\AirLines\Pages\ListAirLines;
use App\Filament\Resources\AirLines\Pages\ViewAirLine;
use App\Filament\Resources\AirLines\Schemas\AirLineForm;
use App\Filament\Resources\AirLines\Schemas\AirLineInfolist;
use App\Filament\Resources\AirLines\Tables\AirLinesTable;
use App\Models\AirLine;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class AirLineResource extends Resource
{
    protected static ?string $model = AirLine::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPaperAirplane;

    protected static string | UnitEnum | null $navigationGroup = 'Observatorio';

    protected static ?string $navigationLabel = 'Aerolineas';

    protected static ?string $modelLabel = 'Aerolineas';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return AirLineForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return AirLineInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AirLinesTable::configure($table);
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
            'index' => ListAirLines::route('/'),
            'create' => CreateAirLine::route('/create'),
            'view' => ViewAirLine::route('/{record}'),
            'edit' => EditAirLine::route('/{record}/edit'),
        ];
    }
}
