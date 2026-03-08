<?php

namespace App\Filament\Resources\AccommodationPerformances;

use App\Filament\Resources\AccommodationPerformances\Pages\CreateAccommodationPerformance;
use App\Filament\Resources\AccommodationPerformances\Pages\EditAccommodationPerformance;
use App\Filament\Resources\AccommodationPerformances\Pages\ListAccommodationPerformances;
use App\Filament\Resources\AccommodationPerformances\Pages\ViewAccommodationPerformance;
use App\Filament\Resources\AccommodationPerformances\Schemas\AccommodationPerformanceForm;
use App\Filament\Resources\AccommodationPerformances\Schemas\AccommodationPerformanceInfolist;
use App\Filament\Resources\AccommodationPerformances\Tables\AccommodationPerformancesTable;
use App\Models\AccommodationPerformance;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class AccommodationPerformanceResource extends Resource
{
    protected static ?string $model = AccommodationPerformance::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChartBar;

    protected static string | UnitEnum | null $navigationGroup = 'Observatorio';

    protected static ?string $navigationLabel = 'Desempeño de alojamientos';

    protected static ?string $modelLabel = 'Desempeño de alojamientos';

    public static function form(Schema $schema): Schema
    {
        return AccommodationPerformanceForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return AccommodationPerformanceInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AccommodationPerformancesTable::configure($table);
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
            'index' => ListAccommodationPerformances::route('/'),
            'create' => CreateAccommodationPerformance::route('/create'),
            'view' => ViewAccommodationPerformance::route('/{record}'),
            'edit' => EditAccommodationPerformance::route('/{record}/edit'),
        ];
    }
}
