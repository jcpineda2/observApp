<?php

namespace App\Filament\Resources\AuditLogs\Tables;

use App\Models\AuditLog;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class AuditLogsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')
                    ->label('Fecha')
                    ->dateTime('d/m/Y H:i:s')
                    ->sortable(),
                TextColumn::make('user.name')
                    ->label('Usuario')
                    ->placeholder('Sistema')
                    ->searchable(),

                TextColumn::make('module')
                    ->label('Módulo')
                    ->badge()
                    ->searchable(),

                TextColumn::make('event')
                    ->label('Evento')
                    ->badge()
                    ->searchable(),

                TextColumn::make('description')
                    ->label('Descripción')
                    ->wrap()
                    ->searchable(),

                TextColumn::make('auditable_type')
                    ->label('Modelo')
                    ->formatStateUsing(fn(?string $state) => $state ? class_basename($state) : '-')
                    ->toggleable(),

                TextColumn::make('auditable_id')
                    ->label('ID')
                    ->toggleable(),
            ])
            ->filters([
                SelectFilter::make('event')
                    ->label('Evento')
                    ->options([
                        'created' => 'Creado',
                        'updated' => 'Actualizado',
                        'deleted' => 'Eliminado',
                        'custom' => 'Personalizado',
                    ]),

                SelectFilter::make('module')
                    ->label('Módulo')
                    ->options(fn() => AuditLog::query()
                        ->whereNotNull('module')
                        ->distinct()
                        ->orderBy('module')
                        ->pluck('module', 'module')
                        ->toArray()),

                SelectFilter::make('user_id')
                    ->label('Usuario')
                    ->relationship('user', 'name'),

                Filter::make('created_at')
                    ->label('Rango de fechas')
                    ->form([
                        DatePicker::make('from')->label('Desde'),
                        DatePicker::make('until')->label('Hasta'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['from'] ?? null, fn($q, $date) => $q->whereDate('created_at', '>=', $date))
                            ->when($data['until'] ?? null, fn($q, $date) => $q->whereDate('created_at', '<=', $date));
                    }),
            ])
            ->recordActions('view')
            ->actions([
                ViewAction::make(),
            ])
            ->bulkActions([]);

    }
}
