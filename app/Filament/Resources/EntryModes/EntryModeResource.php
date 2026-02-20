<?php

namespace App\Filament\Resources\EntryModes;

use App\Filament\Resources\EntryModes\Pages\CreateEntryMode;
use App\Filament\Resources\EntryModes\Pages\EditEntryMode;
use App\Filament\Resources\EntryModes\Pages\ListEntryModes;
use App\Filament\Resources\EntryModes\Pages\ViewEntryMode;
use App\Filament\Resources\EntryModes\Schemas\EntryModeForm;
use App\Filament\Resources\EntryModes\Schemas\EntryModeInfolist;
use App\Filament\Resources\EntryModes\Tables\EntryModesTable;
use App\Models\EntryMode;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class EntryModeResource extends Resource
{
    protected static ?string $model = EntryMode::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::RocketLaunch;

    protected static string | UnitEnum | null $navigationGroup = 'Parámetros';

    protected static ?string $recordTitleAttribute = 'type'; //Via de ingreso

    protected static ?string $modelLabel = 'Vía de Ingreso'; //Via de ingreso


    protected static ?string $navigationLabel = 'Via de Ingreso ';


    public static function form(Schema $schema): Schema
    {
        return EntryModeForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return EntryModeInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return EntryModesTable::configure($table);
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
            'index' => ListEntryModes::route('/'),
            'create' => CreateEntryMode::route('/create'),
            'view' => ViewEntryMode::route('/{record}'),
            'edit' => EditEntryMode::route('/{record}/edit'),
        ];
    }
}
