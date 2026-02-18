<?php

namespace App\Filament\Resources\InboundTourisms;

use App\Filament\Resources\InboundTourisms\Pages\CreateInboundTourism;
use App\Filament\Resources\InboundTourisms\Pages\EditInboundTourism;
use App\Filament\Resources\InboundTourisms\Pages\ListInboundTourisms;
use App\Filament\Resources\InboundTourisms\Pages\ViewInboundTourism;
use App\Filament\Resources\InboundTourisms\Schemas\InboundTourismForm;
use App\Filament\Resources\InboundTourisms\Schemas\InboundTourismInfolist;
use App\Filament\Resources\InboundTourisms\Tables\InboundTourismsTable;
use App\Models\InboundTourism;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class InboundTourismResource extends Resource
{
    protected static ?string $model = InboundTourism::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Camera;

    protected static string | UnitEnum | null $navigationGroup = 'Indicadores';

    protected static ?string $navigationLabel = 'Turismo Receptivo ';


    public static function form(Schema $schema): Schema
    {
        return InboundTourismForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return InboundTourismInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return InboundTourismsTable::configure($table);
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
            'index' => ListInboundTourisms::route('/'),
            'create' => CreateInboundTourism::route('/create'),
            'view' => ViewInboundTourism::route('/{record}'),
            'edit' => EditInboundTourism::route('/{record}/edit'),
        ];
    }
}
