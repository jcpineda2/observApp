<?php

namespace App\Filament\Resources\AccommodationCategories;

use App\Filament\Concerns\HasResourcePermissions;
use App\Filament\Resources\AccommodationCategories\Pages\CreateAccommodationCategory;
use App\Filament\Resources\AccommodationCategories\Pages\EditAccommodationCategory;
use App\Filament\Resources\AccommodationCategories\Pages\ListAccommodationCategories;
use App\Filament\Resources\AccommodationCategories\Pages\ViewAccommodationCategory;
use App\Filament\Resources\AccommodationCategories\Schemas\AccommodationCategoryForm;
use App\Filament\Resources\AccommodationCategories\Schemas\AccommodationCategoryInfolist;
use App\Filament\Resources\AccommodationCategories\Tables\AccommodationCategoriesTable;
use App\Models\AccommodationCategory;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Spatie\Permission\Traits\HasPermissions;
use UnitEnum;

class AccommodationCategoryResource extends Resource
{
    use HasResourcePermissions;

    protected static ?string $permissionSubject = 'accommodation-categories';

    protected static ?string $model = AccommodationCategory::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTag;

    protected static string | UnitEnum | null $navigationGroup = 'Parámetros';

    protected static ?string $recordTitleAttribute = 'description'; //categoria_alojamiento

    protected static ?string $navigationLabel = 'Categorias de Alojamiento';

    protected static ?string $modelLabel = 'Categorias';



    public static function form(Schema $schema): Schema
    {
        return AccommodationCategoryForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return AccommodationCategoryInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AccommodationCategoriesTable::configure($table);
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
            'index' => ListAccommodationCategories::route('/'),
            'create' => CreateAccommodationCategory::route('/create'),
            'view' => ViewAccommodationCategory::route('/{record}'),
            'edit' => EditAccommodationCategory::route('/{record}/edit'),
        ];
    }
}
