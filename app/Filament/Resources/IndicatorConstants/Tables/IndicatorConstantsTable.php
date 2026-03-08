<?php

namespace App\Filament\Resources\IndicatorConstants\Tables;

use App\Enums\IndicatorDomain;
use App\Enums\IndicatorKey;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class IndicatorConstantsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('domain')
                    ->label('Dominio')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('key')
                    ->label('Indicador')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('year.year')
                    ->label('Año')
                    ->sortable()
                    ->placeholder('-'),

                TextColumn::make('value')
                    ->label('Valor')
                    ->sortable(),

                TextColumn::make('unit')
                    ->label('Unidad')
                    ->placeholder('-'),

                TextColumn::make('source')
                    ->label('Fuente')
                    ->limit(30)
                    ->placeholder('-'),

                TextColumn::make('updated_at')
                    ->label('Actualizado')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('domain')
                    ->label('Dominio')
                    ->options([
                        IndicatorDomain::cases(),
                    ]),
                SelectFilter::make('key')
                    ->label('Indicador')
                    ->options([
                        IndicatorKey::cases(),
                    ]),
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
