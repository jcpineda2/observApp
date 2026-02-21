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
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Validation\Rule;

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
                    ->required()
                    ->rules(function (Get $get, $record) {
                        $parentId = $this->getOwnerRecord()->getKey(); // TourismEmployment id

                        $rule = Rule::unique('employment_demographics')
                            ->where(
                                fn($q) => $q
                                    ->where('tourism_employment_id', $parentId)
                                    ->where('gender', $get('gender'))
                                    ->where('age_range', $get('age_range'))
                            );

                        if ($record) {
                            $rule->ignore($record->getKey());
                        }

                        return [$rule];
                    })
                    ->validationMessages([
                        'unique' => 'Ya existe una fila demográfica con ese Género y Rango para este Empleo.',
                    ]),
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
