<?php

namespace App\Filament\Resources\InboundArrivalByMonths;

use App\Filament\Resources\InboundArrivalByMonths\Pages\CreateInboundArrivalByMonth;
use App\Filament\Resources\InboundArrivalByMonths\Pages\EditInboundArrivalByMonth;
use App\Filament\Resources\InboundArrivalByMonths\Pages\ListInboundArrivalByMonths;
use App\Filament\Resources\InboundArrivalByMonths\Schemas\InboundArrivalByMonthForm;
use App\Filament\Resources\InboundArrivalByMonths\Tables\InboundArrivalByMonthsTable;
use App\Models\InboundArrivalByMonth;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class InboundArrivalByMonthResource extends Resource
{
    protected static ?string $model = InboundArrivalByMonth::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return InboundArrivalByMonthForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return InboundArrivalByMonthsTable::configure($table);
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
            'index' => ListInboundArrivalByMonths::route('/'),
            'create' => CreateInboundArrivalByMonth::route('/create'),
            'edit' => EditInboundArrivalByMonth::route('/{record}/edit'),
        ];
    }
}
