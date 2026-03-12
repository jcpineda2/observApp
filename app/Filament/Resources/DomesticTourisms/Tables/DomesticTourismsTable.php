<?php

namespace App\Filament\Resources\DomesticTourisms\Tables;

use App\Filament\Resources\DomesticTourisms\DomesticTourismResource;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class DomesticTourismsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('year.year')
                    ->label('Año')
                    ->searchable(),
                TextColumn::make('month.month')
                    ->label('Més')
                    ->searchable(),
                TextColumn::make('destinationDepartment.name')
                    ->label('Dpartamento Destino')
                    ->sortable(),

                TextColumn::make('originRegion.name')
                    ->label('Región de origen')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('travelReason.description')
                    ->searchable(),
                TextColumn::make('tourist_quantity')
                    ->label('Cantidad de Turistas')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('total_spend')
                    ->label('Gasto observado')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('average_stay')
                    ->label('Estadía observada')
                    ->numeric()
                    ->sortable(),
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
                SelectFilter::make('year_id')->relationship('year', 'year')->label('Año'),
                SelectFilter::make('month_id')->relationship('month', 'month')->label('Mes'),
                SelectFilter::make('destination_department_id')
                    ->relationship('destinationDepartment', 'name')
                    ->label('Departamento destino'),
                SelectFilter::make('travel_reason_id')->relationship('travelReason', 'description')->label('Motivo'),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()->visible(fn (): bool => DomesticTourismResource::canDeleteAny()),
                ]),
            ]);
    }
}
