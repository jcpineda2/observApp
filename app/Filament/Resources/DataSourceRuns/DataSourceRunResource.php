<?php

namespace App\Filament\Resources\DataSourceRuns;

use App\Filament\Resources\DataSourceRuns\Pages\CreateDataSourceRun;
use App\Filament\Resources\DataSourceRuns\Pages\EditDataSourceRun;
use App\Filament\Resources\DataSourceRuns\Pages\ListDataSourceRuns;
use App\Filament\Resources\DataSourceRuns\Schemas\DataSourceRunForm;
use App\Filament\Resources\DataSourceRuns\Tables\DataSourceRunsTable;
use App\Models\DataSourceRun;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class DataSourceRunResource extends Resource
{
    protected static ?string $model = DataSourceRun::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return DataSourceRunForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DataSourceRunsTable::configure($table);
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
            'index' => ListDataSourceRuns::route('/'),
            'create' => CreateDataSourceRun::route('/create'),
            'edit' => EditDataSourceRun::route('/{record}/edit'),
        ];
    }
}
