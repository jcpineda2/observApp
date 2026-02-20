<?php

namespace App\Filament\Resources\TourismProviders;

use App\Filament\Resources\TourismProviders\Pages\CreateTourismProvider;
use App\Filament\Resources\TourismProviders\Pages\EditTourismProvider;
use App\Filament\Resources\TourismProviders\Pages\ListTourismProviders;
use App\Filament\Resources\TourismProviders\Pages\ViewTourismProvider;
use App\Filament\Resources\TourismProviders\Schemas\TourismProviderForm;
use App\Filament\Resources\TourismProviders\Schemas\TourismProviderInfolist;
use App\Filament\Resources\TourismProviders\Tables\TourismProvidersTable;
use App\Models\TourismProvider;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class TourismProviderResource extends Resource
{
    protected static ?string $model = TourismProvider::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedMegaphone;

    protected static string | UnitEnum | null $navigationGroup = 'Infraestructura';

    protected static ?string $navigationLabel = 'Prestadores (PST)';

    protected static ?string $modelLabel = 'Prestadores (PST)';


    public static function form(Schema $schema): Schema
    {
        return TourismProviderForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return TourismProviderInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TourismProvidersTable::configure($table);
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
            'index' => ListTourismProviders::route('/'),
            'create' => CreateTourismProvider::route('/create'),
            'view' => ViewTourismProvider::route('/{record}'),
            'edit' => EditTourismProvider::route('/{record}/edit'),
        ];
    }
}
