<?php

namespace App\Filament\Resources\ConnectivityIndicators;

use App\Filament\Resources\ConnectivityIndicators\Pages\CreateConnectivityIndicator;
use App\Filament\Resources\ConnectivityIndicators\Pages\EditConnectivityIndicator;
use App\Filament\Resources\ConnectivityIndicators\Pages\ListConnectivityIndicators;
use App\Filament\Resources\ConnectivityIndicators\Pages\ViewConnectivityIndicator;
use App\Filament\Resources\ConnectivityIndicators\Schemas\ConnectivityIndicatorForm;
use App\Filament\Resources\ConnectivityIndicators\Schemas\ConnectivityIndicatorInfolist;
use App\Filament\Resources\ConnectivityIndicators\Tables\ConnectivityIndicatorsTable;
use App\Models\ConnectivityIndicator;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class ConnectivityIndicatorResource extends Resource
{
    protected static ?string $model = ConnectivityIndicator::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static string | UnitEnum | null $navigationGroup = 'Indicadores';


    public static function form(Schema $schema): Schema
    {
        return ConnectivityIndicatorForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ConnectivityIndicatorInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ConnectivityIndicatorsTable::configure($table);
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
            'index' => ListConnectivityIndicators::route('/'),
            'create' => CreateConnectivityIndicator::route('/create'),
            'view' => ViewConnectivityIndicator::route('/{record}'),
            'edit' => EditConnectivityIndicator::route('/{record}/edit'),
        ];
    }
}
