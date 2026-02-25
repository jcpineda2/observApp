<?php

namespace App\Filament\Resources\AccommodationPerformances\Tables;

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
                    TextColumn::make('accommodation.category.category')
                        ->label('Categoría de Alojamiento')
                        ->searchable()
                        ->sortable(),
                    TextColumn::make('year.year')
                        ->label('Año')
                        ->searchable()
                        ->sortable(),
                    TextColumn::make('month.month')
                        ->label('Més')
                        ->searchable(),
                    TextColumn::make('occupancy_rate')
                        ->label('Tasa de ocupación (%)')
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
                    SelectFilter::make('state_id')
                        ->label('Departamento')
                        ->query(function ($query, array $data) {
                            if (blank($data['value'] ?? null)) return $query;

                            return $query->whereHas('accommodation', fn($q) => $q->where('state_id', $data['value']));
                        })
                        ->options(State::query()->orderBy('name')->pluck('name', 'id')->toArray())
                        ->searchable(),

                    SelectFilter::make('accommodation_category_id')
                        ->label('Categoría')
                        ->query(function ($query, array $data) {
                            if (blank($data['value'] ?? null)) return $query;

                            return $query->whereHas('accommodation', fn($q) => $q->where('accommodation_category_id', $data['value']));
                        })
                        ->options(AccommodationCategory::query()->orderBy('category')->pluck('category', 'id')->toArray())
                        ->searchable(),
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
