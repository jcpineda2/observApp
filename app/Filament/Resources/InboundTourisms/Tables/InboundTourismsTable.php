<?php

namespace App\Filament\Resources\InboundTourisms\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use PhpParser\Node\Stmt\Label;

class InboundTourismsTable
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
                TextColumn::make('country.name')
                    ->label('País de Residencia')
                    ->sortable(),
                TextColumn::make('entryMode.description')
                    ->label('Vía de Ingreso')
                    ->searchable(),
                TextColumn::make('travelReason.description')
                    ->label('Motivo de viaje')
                    ->searchable(),
                TextColumn::make('tourist_arrivals')
                    ->label('Llegadas Turistas')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('excursionist_arrivals')
                    ->label('Llegadas Excursionistas')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('foreign_exchange_revenue')
                    ->label('Ingreso de divisas')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('average_spend')
                    ->label('Gasto promedio')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('average_stay')
                    ->label('Estadía primedio')
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

                SelectFilter::make('year_id')
                    ->relationship('year', 'name'),

                SelectFilter::make('month_id')
                    ->relationship('month', 'name'),

                SelectFilter::make('residence_country_id')
                    ->relationship('residenceCountry', 'name'),

                SelectFilter::make('entry_mode_id')
                    ->relationship('entryMode', 'name'),

                SelectFilter::make('travel_reason_id')
                    ->relationship('travelReason', 'name'),

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
