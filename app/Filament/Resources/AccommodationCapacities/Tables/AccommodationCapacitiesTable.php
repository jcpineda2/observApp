<?php

namespace App\Filament\Resources\AccommodationCapacities\Tables;

use App\Filament\Resources\AccommodationCapacities\AccommodationCapacityResource;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class AccommodationCapacitiesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('category.category')
                    ->label('Categoría')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('state.name')
                    ->label('Departamento')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('establishments_count')
                    ->label('Establecimientos')
                    ->sortable(),

                TextColumn::make('rooms_count')
                    ->label('Habitaciones')
                    ->sortable(),

                TextColumn::make('beds_count')
                    ->label('Camas')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('accommodation_category_id')
                    ->label('Categoría')
                    ->relationship('category', 'category'),

                SelectFilter::make('state_id')
                    ->label('Departamento')
                    ->relationship('state', 'name'),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()->visible(fn(): bool => AccommodationCapacityResource::canDeleteAny()),
                ]),
            ]);
    }
}
