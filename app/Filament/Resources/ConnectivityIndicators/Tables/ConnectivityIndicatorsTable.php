<?php

namespace App\Filament\Resources\ConnectivityIndicators\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ConnectivityIndicatorsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('year.year')
                    ->label('Año')
                    ->searchable(),
                TextColumn::make('operating_airports')
                    ->label('Aeropuertos operativos')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('connected_destinations')
                    ->label('Destinos conectados')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('active_routes')
                    ->label('Rutas activas')
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
