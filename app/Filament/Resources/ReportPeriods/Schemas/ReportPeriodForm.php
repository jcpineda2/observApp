<?php

namespace App\Filament\Resources\ReportPeriods\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ReportPeriodForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('year_id')
                    ->relationship('year', 'year')
                    ->label('Año')
                    ->required(),
                Select::make('start_month_id')
                    ->relationship('startMonth', 'month')
                    ->label('Mes inicio')
                    ->required()
                    ->default(null),
                Select::make('end_month_id')
                    ->relationship('endMonth', 'month')
                    ->label('Mes fin')
                    ->required()
                    ->default(null),
                TextInput::make('label')
                    ->label('Descripción')
                    ->placeholder('Ej.: Enero a junio')
                    ->required(),
                Toggle::make('is_full_year')
                    ->label('Periodo completo')
                    ->required(),
            ]);
    }
}
