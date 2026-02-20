<?php

namespace App\Filament\Resources\ProviderIndicators\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProviderIndicatorsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('year.year')
                    ->label('Año')
                    ->searchable(),
                TextColumn::make('total_providers')
                    ->label('Total Prestadores')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('new_registrations')
                    ->label('Altas')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('cancellations')
                    ->label('Bajas')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('formalization_rate')
                    ->label('Porcentaje de Formalización')
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
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
