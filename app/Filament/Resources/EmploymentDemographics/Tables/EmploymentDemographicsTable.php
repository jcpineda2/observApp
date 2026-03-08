<?php

namespace App\Filament\Resources\EmploymentDemographics\Tables;

use App\Enums\Gender;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class EmploymentDemographicsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('employment.year.year')
                    ->label('Año')
                    ->sortable(),
                TextColumn::make('employment.serviceSector.description')
                    ->label('Segmento / Rubro')
                    ->sortable(),
                TextColumn::make('gender')
                    ->label('Género')
                    ->badge()
                    ->searchable(),
                TextColumn::make('geRange.name')
                    ->label('Rango de edad')
                    ->searchable(),
                TextColumn::make('people_count')
                    ->label('Cantidad de personas')
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
                SelectFilter::make('gender')
                    ->label('Género')
                    ->options(Gender::class),

                SelectFilter::make('age_range_id')
                    ->label('Rango de edad')
                    ->relationship('ageRange', 'name'),
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
