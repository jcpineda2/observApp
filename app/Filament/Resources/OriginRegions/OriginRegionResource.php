<?php

namespace App\Filament\Resources\OriginRegions;

use App\Filament\Concerns\HasResourcePermissions;
use App\Filament\Resources\OriginRegions\Pages\CreateOriginRegion;
use App\Filament\Resources\OriginRegions\Pages\EditOriginRegion;
use App\Filament\Resources\OriginRegions\Pages\ListOriginRegions;
use App\Filament\Resources\OriginRegions\Schemas\OriginRegionForm;
use App\Filament\Resources\OriginRegions\Tables\OriginRegionsTable;
use App\Models\OriginRegion;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class OriginRegionResource extends Resource
{
    use HasResourcePermissions;

    protected static ?string $permissionSubject = 'origin-regions';

    protected static ?string $model = OriginRegion::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static string | UnitEnum | null $navigationGroup = 'Parámetros';

    protected static ?string $navigationLabel = 'Regiones de origen';

    protected static ?string $modelLabel = 'Región de origen';

    protected static ?string $pluralModelLabel = 'Regiones de origen';

    public static function form(Schema $schema): Schema
    {
        return OriginRegionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return OriginRegionsTable::configure($table);
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
            'index' => ListOriginRegions::route('/'),
            'create' => CreateOriginRegion::route('/create'),
            'edit' => EditOriginRegion::route('/{record}/edit'),
        ];
    }
}
