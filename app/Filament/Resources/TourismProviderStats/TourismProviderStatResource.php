<?php

namespace App\Filament\Resources\TourismProviderStats;

use App\Filament\Concerns\HasResourcePermissions;
use App\Filament\Resources\TourismProviderStats\Pages\CreateTourismProviderStat;
use App\Filament\Resources\TourismProviderStats\Pages\EditTourismProviderStat;
use App\Filament\Resources\TourismProviderStats\Pages\ListTourismProviderStats;
use App\Filament\Resources\TourismProviderStats\Schemas\TourismProviderStatForm;
use App\Filament\Resources\TourismProviderStats\Tables\TourismProviderStatsTable;
use App\Models\TourismProviderStat;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class TourismProviderStatResource extends Resource
{

    use HasResourcePermissions;

    protected static ?string $permissionSubject = 'tourism-provider-stats';

    protected static ?string $model = TourismProviderStat::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChartBar;

    protected static string|UnitEnum|null $navigationGroup = 'Observatorio';

    protected static ?string $navigationLabel = 'Prestadores (mensual)';

    protected static ?string $modelLabel = 'Prestador (mensual)';

    protected static ?string $pluralModelLabel = 'Prestadores (mensual)';


    public static function form(Schema $schema): Schema
    {
        return TourismProviderStatForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TourismProviderStatsTable::configure($table);
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
            'index' => ListTourismProviderStats::route('/'),
            'create' => CreateTourismProviderStat::route('/create'),
            'edit' => EditTourismProviderStat::route('/{record}/edit'),
        ];
    }
}
