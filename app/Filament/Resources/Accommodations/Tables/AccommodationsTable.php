<?php

namespace App\Filament\Resources\Accommodations\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AccommodationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('category.category')
                    ->label('Categoría')
                    ->sortable(),
                TextColumn::make('state.name')
                    ->label('Estado')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('establishments_count')
                    ->label('Cantidad de Establecimientos')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('rooms_count')
                    ->label('Cantidad habitaciones')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('beds_count')
                    ->label('Cantidad camas')
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
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
