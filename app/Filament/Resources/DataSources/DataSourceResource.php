<?php

namespace App\Filament\Resources\DataSources;

use App\Filament\Concerns\HasResourcePermissions;
use App\Filament\Resources\DataSources\Pages\CreateDataSource;
use App\Filament\Resources\DataSources\Pages\EditDataSource;
use App\Filament\Resources\DataSources\Pages\ListDataSources;
use App\Filament\Resources\DataSources\Schemas\DataSourceForm;
use App\Filament\Resources\DataSources\Tables\DataSourcesTable;
use App\Models\DataSource;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class DataSourceResource extends Resource
{
    use HasResourcePermissions;

    protected static ?string $permissionSubject = 'data-sources';

    protected static ?string $model = DataSource::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static string | UnitEnum | null $navigationGroup = 'Parámetros';

    protected static ?string $navigationLabel = 'Recurso de datos';

    protected static ?string $modelLabel = 'Recurso de datos';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return DataSourceForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DataSourcesTable::configure($table);
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
            'index' => ListDataSources::route('/'),
            'create' => CreateDataSource::route('/create'),
            'edit' => EditDataSource::route('/{record}/edit'),
        ];
    }
}
