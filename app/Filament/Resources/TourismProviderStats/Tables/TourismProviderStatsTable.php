<?php

namespace App\Filament\Resources\TourismProviderStats\Tables;

use App\Models\State;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class TourismProviderStatsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('year.year')
                    ->label('Año')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('month.month')
                    ->label('Mes')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('serviceSector.description')
                    ->label('Rubro')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('state.name')
                    ->label('Departamento')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('total_registered')
                    ->label('Total')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('registrations')
                    ->label('Altas')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('cancellations')
                    ->label('Bajas')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('formalized_total')
                    ->label('Formalizados')
                    ->numeric()
                    ->sortable(),

                // % formalización calculado (sin guardar columna extra)
                TextColumn::make('formalization_percent')
                    ->label('Formalización (%)')
                    ->state(fn ($record) => $record->total_registered > 0
                        ? round(($record->formalized_total / $record->total_registered) * 100, 2)
                        : 0
                    )
                    ->numeric()
                    ->sortable(),

                TextColumn::make('updated_at')
                    ->label('Actualizado')
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

                SelectFilter::make('service_sector_id')
                    ->label('Rubro')
                    ->relationship('serviceSector', 'description'),

                SelectFilter::make('state_id')
                    ->label('Departamento')
                    ->options(fn () => State::query()
                        ->orderBy('name')
                        ->whereHas('country', fn($q) => $q->where('name', 'Paraguay'))
                        ->pluck('name', 'id')
                        ->toArray()
                    )
                    ->searchable(),
            ])
            ->recordActions([
                EditAction::make(),
                // \Filament\Actions\ViewAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
