<?php

namespace App\Filament\Resources\DataSourceRuns\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class DataSourceRunsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('dataSource.name')
                    ->searchable(),
                TextColumn::make('reportPeriod.id')
                    ->searchable(),
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('source_file_name')
                    ->searchable(),
                TextColumn::make('source_file_path')
                    ->searchable(),
                TextColumn::make('source_sheet_name')
                    ->searchable(),
                TextColumn::make('external_reference')
                    ->searchable(),
                TextColumn::make('source_url')
                    ->searchable(),
                TextColumn::make('checksum')
                    ->searchable(),
                TextColumn::make('extracted_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('imported_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('validated_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('imported_by')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('validated_by')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('status')
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
                //
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
