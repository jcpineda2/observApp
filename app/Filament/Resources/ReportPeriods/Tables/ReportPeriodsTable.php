<?php

namespace App\Filament\Resources\ReportPeriods\Tables;

use App\Filament\Resources\ReportPeriods\ReportPeriodResource;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ReportPeriodsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('year.year')
                    ->label('Año')
                    ->searchable(),
                TextColumn::make('startMonth.month')
                    ->label('Mes inicio')
                    ->searchable(),
                TextColumn::make('endMonth.month')
                    ->label('Mes fin')
                    ->searchable(),
                TextColumn::make('label')
                    ->label('Descropción')
                    ->searchable(),
                IconColumn::make('is_full_year')
                    ->label('Periodo completo')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()->visible(fn(): bool => ReportPeriodResource::canDeleteAny()),
                ]),
            ]);
    }
}
