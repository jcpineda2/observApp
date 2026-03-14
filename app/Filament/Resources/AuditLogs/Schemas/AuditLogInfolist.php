<?php

namespace App\Filament\Resources\AuditLogs\Schemas;

use Filament\Infolists\Components\KeyValueEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AuditLogInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Auditoría')
                    ->schema([
                        Section::make('Información general')
                            ->schema([
                                Grid::make(3)
                                    ->schema([
                                        TextEntry::make('id')
                                            ->label('ID'),

                                        TextEntry::make('event')
                                            ->label('Evento')
                                            ->badge()
                                            ->formatStateUsing(fn(string $state): string => match ($state) {
                                                'created' => 'Creado',
                                                'updated' => 'Actualizado',
                                                'deleted' => 'Eliminado',
                                                default => ucfirst($state),
                                            })
                                            ->color(fn(string $state): string => match ($state) {
                                                'created' => 'success',
                                                'updated' => 'warning',
                                                'deleted' => 'danger',
                                                default => 'gray',
                                            }),

                                        TextEntry::make('created_at')
                                            ->label('Fecha')
                                            ->dateTime('d/m/Y H:i:s'),

                                        TextEntry::make('module')
                                            ->label('Módulo'),

                                        TextEntry::make('auditable_type')
                                            ->label('Modelo')
                                            ->formatStateUsing(fn(?string $state): string => $state ? class_basename($state) : '-'),

                                        TextEntry::make('auditable_id')
                                            ->label('ID del registro'),

                                        TextEntry::make('user.name')
                                            ->label('Usuario')
                                            ->placeholder('Sistema'),

                                        TextEntry::make('ip_address')
                                            ->label('IP')
                                            ->placeholder('-'),

                                        TextEntry::make('url')
                                            ->label('URL')
                                            ->placeholder('-')
                                            ->columnSpanFull(),
                                    ]),
                            ]),

                        Section::make('Descripción')
                            ->schema([
                                TextEntry::make('description')
                                    ->label('')
                                    ->placeholder('-')
                                    ->columnSpanFull(),
                            ])
                            ->collapsible(),

                        Section::make('Valores anteriores')
                            ->schema([
                                KeyValueEntry::make('old_values')
                                    ->label('')
                                    ->columnSpanFull(),
                            ])
                            ->collapsible(),

                        Section::make('Valores nuevos')
                            ->schema([
                                KeyValueEntry::make('new_values')
                                    ->label('')
                                    ->columnSpanFull(),
                            ])
                            ->collapsible(),

                        Section::make('Contexto técnico')
                            ->schema([
                                TextEntry::make('user_agent')
                                    ->label('User Agent')
                                    ->placeholder('-')
                                    ->columnSpanFull(),
                            ])
                            ->collapsed()
                            ->collapsible(),

                    ])
                    ,

                Section::make('Valores anteriores')
                    ->schema([
                        TextEntry::make('old_values')
                            ->label('')
                            ->state(fn($record) => json_encode($record->old_values ?? [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE))
                            ->columnSpanFull(),
                    ]),

                Section::make('Valores nuevos')
                    ->schema([
                        TextEntry::make('new_values')
                            ->label('')
                            ->state(fn($record) => json_encode($record->new_values ?? [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE))
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
