<?php

namespace App\Filament\Resources\Continents;

use App\Filament\Concerns\HasResourcePermissions;
use App\Filament\Resources\Continents\Pages\CreateContinent;
use App\Filament\Resources\Continents\Pages\EditContinent;
use App\Filament\Resources\Continents\Pages\ListContinents;
use App\Filament\Resources\Continents\Schemas\ContinentForm;
use App\Filament\Resources\Continents\Tables\ContinentsTable;
use App\Models\Continent;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class ContinentResource extends Resource
{
    use HasResourcePermissions;

    protected static ?string $model = Continent::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static string | UnitEnum | null $navigationGroup = 'Parámetros';

    protected static ?string $navigationLabel = 'Continentes';

    protected static ?string $modelLabel = 'Continentes';

    protected static ?string $recordTitleAttribute = 'continent';

    public static function form(Schema $schema): Schema
    {
        return ContinentForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ContinentsTable::configure($table);
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
            'index' => ListContinents::route('/'),
            'create' => CreateContinent::route('/create'),
            'edit' => EditContinent::route('/{record}/edit'),
        ];
    }
}
