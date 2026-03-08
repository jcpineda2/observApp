<?php

namespace App\Filament\Resources\AccommodationPerformances\Tables;

use App\Enums\Season;
use App\Models\AccommodationCategory;
use App\Models\State;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class AccommodationPerformancesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('year.year')
                    ->label('Año')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('month.month')
                    ->label('Més')
                    ->searchable(),
                TextColumn::make('state.name')
                    ->label('Departamento')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('occupancy_rate')
                    ->label('Ocupación (%)')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('season')
                    ->label('Temporada')
                    ->searchable(),
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
                    ->label('Año')
                    ->relationship('year', 'year'),

                SelectFilter::make('month_id')
                    ->label('Mes')
                    ->relationship('month', 'month'),

                SelectFilter::make('state_id')
                    ->label('Departamento')
                    ->relationship('state', 'name'),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //DeleteBulkAction::make(),
                ]),
            ]);
    }
}
