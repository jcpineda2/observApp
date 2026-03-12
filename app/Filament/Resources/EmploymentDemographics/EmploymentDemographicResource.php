<?php

namespace App\Filament\Resources\EmploymentDemographics;

use App\Filament\Concerns\HasResourcePermissions;
use App\Filament\Resources\EmploymentDemographics\Pages\CreateEmploymentDemographic;
use App\Filament\Resources\EmploymentDemographics\Pages\EditEmploymentDemographic;
use App\Filament\Resources\EmploymentDemographics\Pages\ListEmploymentDemographics;
use App\Filament\Resources\EmploymentDemographics\Pages\ViewEmploymentDemographic;
use App\Filament\Resources\EmploymentDemographics\Schemas\EmploymentDemographicForm;
use App\Filament\Resources\EmploymentDemographics\Schemas\EmploymentDemographicInfolist;
use App\Filament\Resources\EmploymentDemographics\Tables\EmploymentDemographicsTable;
use App\Models\EmploymentDemographic;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class EmploymentDemographicResource extends Resource
{
    use HasResourcePermissions;

    protected static ?string $permissionSubject = 'employment-demographics';

    protected static ?string $model = EmploymentDemographic::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static string | UnitEnum | null $navigationGroup = 'Observatorio';

    protected static ?string $navigationLabel = 'Demografía del empleo';

    protected static ?string $modelLabel = 'Demografía del empleo';

    public static function form(Schema $schema): Schema
    {
        return EmploymentDemographicForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return EmploymentDemographicInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return EmploymentDemographicsTable::configure($table);
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
            'index' => ListEmploymentDemographics::route('/'),
            'create' => CreateEmploymentDemographic::route('/create'),
            'view' => ViewEmploymentDemographic::route('/{record}'),
            'edit' => EditEmploymentDemographic::route('/{record}/edit'),
        ];
    }
}
