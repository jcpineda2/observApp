<?php

namespace App\Filament\Resources\ReportPeriods;

use App\Filament\Concerns\HasResourcePermissions;
use App\Filament\Resources\ReportPeriods\Pages\CreateReportPeriod;
use App\Filament\Resources\ReportPeriods\Pages\EditReportPeriod;
use App\Filament\Resources\ReportPeriods\Pages\ListReportPeriods;
use App\Filament\Resources\ReportPeriods\Schemas\ReportPeriodForm;
use App\Filament\Resources\ReportPeriods\Tables\ReportPeriodsTable;
use App\Models\ReportPeriod;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class ReportPeriodResource extends Resource
{
    use HasResourcePermissions;

    protected static ?string $permissionSubject = 'report-period';

    protected static ?string $model = ReportPeriod::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static string | UnitEnum | null $navigationGroup = 'Parámetros';

    protected static ?string $navigationLabel = 'Periodo de reportes';

    protected static ?string $modelLabel = 'Periodo de reportes';

    protected static ?string $recordTitleAttribute = 'label';

    public static function form(Schema $schema): Schema
    {
        return ReportPeriodForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ReportPeriodsTable::configure($table);
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
            'index' => ListReportPeriods::route('/'),
            'create' => CreateReportPeriod::route('/create'),
            'edit' => EditReportPeriod::route('/{record}/edit'),
        ];
    }
}
