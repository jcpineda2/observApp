<?php

namespace App\Filament\Resources\AirConnectivityRoutes;

use App\Filament\Resources\AirConnectivityRoutes\Pages\CreateAirConnectivityRoute;
use App\Filament\Resources\AirConnectivityRoutes\Pages\EditAirConnectivityRoute;
use App\Filament\Resources\AirConnectivityRoutes\Pages\ListAirConnectivityRoutes;
use App\Filament\Resources\AirConnectivityRoutes\Schemas\AirConnectivityRouteForm;
use App\Filament\Resources\AirConnectivityRoutes\Tables\AirConnectivityRoutesTable;
use App\Models\AirConnectivityRoute;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class AirConnectivityRouteResource extends Resource
{
    protected static ?string $model = AirConnectivityRoute::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPaperAirplane;

    protected static string|UnitEnum|null $navigationGroup = 'Indicadores';

    protected static ?string $navigationLabel = 'Rutas aéreas';

    protected static ?string $modelLabel = 'Ruta aéreas';

    protected static ?string $pluralModelLabel = 'Rutas aéreas (mensual)';

    public static function form(Schema $schema): Schema
    {
        return AirConnectivityRouteForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AirConnectivityRoutesTable::configure($table);
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
            'index' => ListAirConnectivityRoutes::route('/'),
            'create' => CreateAirConnectivityRoute::route('/create'),
            'edit' => EditAirConnectivityRoute::route('/{record}/edit'),
        ];
    }
}
