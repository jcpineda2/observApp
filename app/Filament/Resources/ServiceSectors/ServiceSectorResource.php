<?php

namespace App\Filament\Resources\ServiceSectors;

use App\Filament\Concerns\HasResourcePermissions;
use App\Filament\Resources\ServiceSectors\Pages\CreateServiceSector;
use App\Filament\Resources\ServiceSectors\Pages\EditServiceSector;
use App\Filament\Resources\ServiceSectors\Pages\ListServiceSectors;
use App\Filament\Resources\ServiceSectors\Pages\ViewServiceSector;
use App\Filament\Resources\ServiceSectors\Schemas\ServiceSectorForm;
use App\Filament\Resources\ServiceSectors\Schemas\ServiceSectorInfolist;
use App\Filament\Resources\ServiceSectors\Tables\ServiceSectorsTable;
use App\Models\ServiceSector;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class ServiceSectorResource extends Resource
{
    use HasResourcePermissions;

    protected static ?string $permissionSubject = 'service-sectors';

    protected static ?string $model = ServiceSector::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedMap;

    protected static string | UnitEnum | null $navigationGroup = 'Parámetros';

    protected static ?string $recordTitleAttribute = 'description'; //rubro de PST (prestador del sector turistico)

    protected static ?string $navigationLabel = 'Rubros';

    protected static ?string $modelLabel = 'Rubros';

    public static function form(Schema $schema): Schema
    {
        return ServiceSectorForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ServiceSectorInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ServiceSectorsTable::configure($table);
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
            'index' => ListServiceSectors::route('/'),
            'create' => CreateServiceSector::route('/create'),
            'view' => ViewServiceSector::route('/{record}'),
            'edit' => EditServiceSector::route('/{record}/edit'),
        ];
    }
}
