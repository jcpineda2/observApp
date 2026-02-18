<?php

namespace App\Filament\Resources\DomesticTourisms;

use App\Filament\Resources\DomesticTourisms\Pages\CreateDomesticTourism;
use App\Filament\Resources\DomesticTourisms\Pages\EditDomesticTourism;
use App\Filament\Resources\DomesticTourisms\Pages\ListDomesticTourisms;
use App\Filament\Resources\DomesticTourisms\Pages\ViewDomesticTourism;
use App\Filament\Resources\DomesticTourisms\Schemas\DomesticTourismForm;
use App\Filament\Resources\DomesticTourisms\Schemas\DomesticTourismInfolist;
use App\Filament\Resources\DomesticTourisms\Tables\DomesticTourismsTable;
use App\Models\DomesticTourism;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class DomesticTourismResource extends Resource
{
    protected static ?string $model = DomesticTourism::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Home;

    protected static string | UnitEnum | null $navigationGroup = 'Indicadores';

    protected static ?string $navigationLabel = 'Turismo Interno ';

    public static function form(Schema $schema): Schema
    {
        return DomesticTourismForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return DomesticTourismInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DomesticTourismsTable::configure($table);
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
            'index' => ListDomesticTourisms::route('/'),
            'create' => CreateDomesticTourism::route('/create'),
            'view' => ViewDomesticTourism::route('/{record}'),
            'edit' => EditDomesticTourism::route('/{record}/edit'),
        ];
    }
}
