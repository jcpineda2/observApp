<?php

namespace App\Filament\Resources\IndicatorConstants;

use App\Filament\Resources\IndicatorConstants\Pages\CreateIndicatorConstant;
use App\Filament\Resources\IndicatorConstants\Pages\EditIndicatorConstant;
use App\Filament\Resources\IndicatorConstants\Pages\ListIndicatorConstants;
use App\Filament\Resources\IndicatorConstants\Schemas\IndicatorConstantForm;
use App\Filament\Resources\IndicatorConstants\Tables\IndicatorConstantsTable;
use App\Models\IndicatorConstant;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class IndicatorConstantResource extends Resource
{
    protected static ?string $model = IndicatorConstant::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::AdjustmentsHorizontal;

    protected static ?string $recordTitleAttribute = 'Constantes';

    protected static ?string $modelLabel = 'Constante';

    protected static ?string $pluralModelLabel = 'Constantes';

    protected static string | UnitEnum | null $navigationGroup = 'Observatorio';

    public static function form(Schema $schema): Schema
    {
        return IndicatorConstantForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return IndicatorConstantsTable::configure($table);
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
            'index' => ListIndicatorConstants::route('/'),
            'create' => CreateIndicatorConstant::route('/create'),
            'edit' => EditIndicatorConstant::route('/{record}/edit'),
        ];
    }
}
