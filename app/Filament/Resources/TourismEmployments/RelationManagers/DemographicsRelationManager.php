<?php

namespace App\Filament\Resources\TourismEmployments\RelationManagers;

use App\Enums\Gender;
use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class DemographicsRelationManager extends RelationManager
{
    protected static string $relationship = 'demographics';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('tourism_employment_id')
                    ->relationship('employment.serviceSector', 'description')
                    ->label('Rubro')
                    ->required(),
                Select::make('gender')
                    ->options(Gender::class)
                    ->label('Género')
                    ->required(),
                TextInput::make('age_range')
                    ->label('Rango de edades')
                    ->required(),
                TextInput::make('people_count')
                    ->label('Cantidad de personas')
                    ->required()
                    ->numeric(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('Rubro')
            ->columns([
                TextColumn::make('employment.serviceSector.description')
                    ->label('Rubro')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
                AssociateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DissociateAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DissociateBulkAction::make(),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
