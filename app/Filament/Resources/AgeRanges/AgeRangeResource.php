<?php

namespace App\Filament\Resources\AgeRanges;

use App\Filament\Concerns\HasResourcePermissions;
use App\Filament\Resources\AgeRanges\Pages\CreateAgeRange;
use App\Filament\Resources\AgeRanges\Pages\EditAgeRange;
use App\Filament\Resources\AgeRanges\Pages\ListAgeRanges;
use App\Filament\Resources\AgeRanges\Schemas\AgeRangeForm;
use App\Filament\Resources\AgeRanges\Tables\AgeRangesTable;
use App\Models\AgeRange;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class AgeRangeResource extends Resource
{
    use HasResourcePermissions;

    protected static ?string $permissionSubject = 'age-ranges';

    protected static ?string $model = AgeRange::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUsers;

    protected static ?string $navigationLabel = 'Rangos de edad';
    protected static ?string $modelLabel = 'Rango de edad';
    protected static ?string $pluralModelLabel = 'Rangos de edad';
    protected static string | UnitEnum | null $navigationGroup = 'Parámetros';


    public static function form(Schema $schema): Schema
    {
        return AgeRangeForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AgeRangesTable::configure($table);
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
            'index' => ListAgeRanges::route('/'),
            'create' => CreateAgeRange::route('/create'),
            'edit' => EditAgeRange::route('/{record}/edit'),
        ];
    }
}
