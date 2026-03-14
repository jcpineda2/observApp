<?php

namespace App\Filament\Resources\AuditLogs\Schemas;

use Filament\Infolists\Components\TextEntry;
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
                        TextEntry::make('created_at')
                            ->label('Fecha')
                            ->dateTime('d/m/Y H:i:s'),

                        TextEntry::make('user.name')
                            ->label('Usuario')
                            ->placeholder('Sistema'),

                        TextEntry::make('module')
                            ->label('Módulo'),

                        TextEntry::make('event')
                            ->label('Evento'),

                        TextEntry::make('description')
                            ->label('Descripción'),

                        TextEntry::make('auditable_type')
                            ->label('Modelo')
                            ->formatStateUsing(fn (?string $state) => $state ? class_basename($state) : '-'),

                        TextEntry::make('auditable_id')
                            ->label('ID del registro'),

                        TextEntry::make('ip_address')
                            ->label('IP')
                            ->placeholder('-'),
                    ])
                    ->columns(2),

                Section::make('Valores anteriores')
                    ->schema([
                        TextEntry::make('old_values')
                            ->label('')
                            ->state(fn ($record) => json_encode($record->old_values ?? [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE))
                            ->columnSpanFull(),
                    ]),

                Section::make('Valores nuevos')
                    ->schema([
                        TextEntry::make('new_values')
                            ->label('')
                            ->state(fn ($record) => json_encode($record->new_values ?? [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE))
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}

