<?php

namespace App\Filament\Resources\AccommodationCapacities;

use App\Filament\Concerns\HasResourcePermissions;
use App\Filament\Resources\AccommodationCapacities\Pages\CreateAccommodationCapacity;
use App\Filament\Resources\AccommodationCapacities\Pages\EditAccommodationCapacity;
use App\Filament\Resources\AccommodationCapacities\Pages\ListAccommodationCapacities;
use App\Filament\Resources\AccommodationCapacities\Schemas\AccommodationCapacityForm;
use App\Filament\Resources\AccommodationCapacities\Tables\AccommodationCapacitiesTable;
use App\Models\AccommodationCapacity;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class AccommodationCapacityResource extends Resource
{

    use HasResourcePermissions;

    protected static ?string $permissionSubject = 'accommodation-capacities';

    protected static ?string $model = AccommodationCapacity::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingOffice2;

    protected static ?string $modelLabel = 'Capacidad de alojamiento';

    protected static ?string $pluralModelLabel = 'Capacidades de alojamiento';

    protected static string | UnitEnum | null $navigationGroup = 'Observatorio';

    public static function form(Schema $schema): Schema
    {
        return AccommodationCapacityForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AccommodationCapacitiesTable::configure($table);
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
            'index' => ListAccommodationCapacities::route('/'),
            'create' => CreateAccommodationCapacity::route('/create'),
            'edit' => EditAccommodationCapacity::route('/{record}/edit'),
        ];
    }
}
