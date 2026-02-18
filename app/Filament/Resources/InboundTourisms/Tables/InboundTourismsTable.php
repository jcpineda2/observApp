<?php

namespace App\Filament\Resources\InboundTourisms\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class InboundTourismsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('year.id')
                    ->searchable(),
                TextColumn::make('month.id')
                    ->searchable(),
                TextColumn::make('residence_country_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('entryMode.id')
                    ->searchable(),
                TextColumn::make('travelReason.id')
                    ->searchable(),
                TextColumn::make('tourist_arrivals')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('excursionist_arrivals')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('foreign_exchange_revenue')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('average_spend')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('average_stay')
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
