<?php

namespace App\Filament\Resources\ProviderIndicators;

use App\Filament\Resources\ProviderIndicators\Pages\CreateProviderIndicator;
use App\Filament\Resources\ProviderIndicators\Pages\EditProviderIndicator;
use App\Filament\Resources\ProviderIndicators\Pages\ListProviderIndicators;
use App\Filament\Resources\ProviderIndicators\Pages\ViewProviderIndicator;
use App\Filament\Resources\ProviderIndicators\Schemas\ProviderIndicatorForm;
use App\Filament\Resources\ProviderIndicators\Schemas\ProviderIndicatorInfolist;
use App\Filament\Resources\ProviderIndicators\Tables\ProviderIndicatorsTable;
use App\Models\ProviderIndicator;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class ProviderIndicatorResource extends Resource
{
    protected static ?string $model = ProviderIndicator::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static string | UnitEnum | null $navigationGroup = 'Indicadores';

    protected static ?string $navigationLabel = 'Indicadores Prestadores';

    protected static ?string $modelLabel = 'Indicadores Prestadores';

    public static function form(Schema $schema): Schema
    {
        return ProviderIndicatorForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ProviderIndicatorInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProviderIndicatorsTable::configure($table);
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
            'index' => ListProviderIndicators::route('/'),
            'create' => CreateProviderIndicator::route('/create'),
            'view' => ViewProviderIndicator::route('/{record}'),
            'edit' => EditProviderIndicator::route('/{record}/edit'),
        ];
    }
}
