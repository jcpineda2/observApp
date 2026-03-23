<?php

namespace App\Filament\Resources\DataSourceRuns\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class DataSourceRunForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('data_source_id')
                    ->relationship('dataSource', 'name')
                    ->required(),
                Select::make('report_period_id')
                    ->relationship('reportPeriod', 'id')
                    ->default(null),
                TextInput::make('name')
                    ->required(),
                TextInput::make('source_file_name')
                    ->default(null),
                TextInput::make('source_file_path')
                    ->default(null),
                TextInput::make('source_sheet_name')
                    ->default(null),
                TextInput::make('external_reference')
                    ->default(null),
                TextInput::make('source_url')
                    ->url()
                    ->default(null),
                TextInput::make('checksum')
                    ->default(null),
                DateTimePicker::make('extracted_at'),
                DateTimePicker::make('imported_at'),
                DateTimePicker::make('validated_at'),
                TextInput::make('imported_by')
                    ->numeric()
                    ->default(null),
                TextInput::make('validated_by')
                    ->numeric()
                    ->default(null),
                TextInput::make('status')
                    ->required()
                    ->default('draft'),
                Textarea::make('notes')
                    ->default(null)
                    ->columnSpanFull(),
            ]);
    }
}
