<?php

namespace App\Filament\Resources\TourismEmployments;

use App\Filament\Resources\TourismEmployments\Pages\CreateTourismEmployment;
use App\Filament\Resources\TourismEmployments\Pages\EditTourismEmployment;
use App\Filament\Resources\TourismEmployments\Pages\ListTourismEmployments;
use App\Filament\Resources\TourismEmployments\Pages\ViewTourismEmployment;
use App\Filament\Resources\TourismEmployments\Schemas\TourismEmploymentForm;
use App\Filament\Resources\TourismEmployments\Schemas\TourismEmploymentInfolist;
use App\Filament\Resources\TourismEmployments\Tables\TourismEmploymentsTable;
use App\Models\TourismEmployment;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class TourismEmploymentResource extends Resource
{
    protected static ?string $model = TourismEmployment::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserCircle;

    protected static string | UnitEnum | null $navigationGroup = 'Estadísticas';

    protected static ?string $navigationLabel = 'Empleo Turístico';

    protected static ?string $modelLabel = 'Empleo Turístico';

    public static function form(Schema $schema): Schema
    {
        return TourismEmploymentForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return TourismEmploymentInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TourismEmploymentsTable::configure($table);
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
            'index' => ListTourismEmployments::route('/'),
            'create' => CreateTourismEmployment::route('/create'),
            'view' => ViewTourismEmployment::route('/{record}'),
            'edit' => EditTourismEmployment::route('/{record}/edit'),
        ];
    }
}
