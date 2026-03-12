<?php

namespace App\Filament\Resources\TourismEmployments\Tables;

use App\Filament\Resources\TourismEmployments\TourismEmploymentResource;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class TourismEmploymentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('year.year')
                    ->label('Año')
                    ->searchable(),
                TextColumn::make('serviceSector.description')
                    ->label('Segmento / Rubro')
                    ->searchable(),
                TextColumn::make('direct_employment')
                    ->label('Empleo directo')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('national_participation')
                    ->label('Participación nacional (%)')
                    ->suffix('%')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('interannual_variation')
                    ->label('Variación interanual (%)')
                    ->suffix('%')
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
                    ->label('Año')
                    ->relationship('year', 'year'),

                SelectFilter::make('service_sector_id')
                    ->label('Rubro')
                    ->relationship('serviceSector', 'description'),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()->visible(fn(): bool => TourismEmploymentResource::canDeleteAny()),
                ]),
            ]);
    }
}
