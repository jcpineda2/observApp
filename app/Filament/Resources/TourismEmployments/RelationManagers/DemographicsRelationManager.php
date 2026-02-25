<?php

namespace App\Filament\Resources\TourismEmployments\RelationManagers;

use App\Enums\Gender;
use BackedEnum;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Validation\Rule;
use UnitEnum;

class DemographicsRelationManager extends RelationManager
{
    protected static string $relationship = 'demographics';

    protected static ?string $title = 'Desglose demográfico';

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('gender')
                ->label('Género')
                ->options(Gender::class)
                ->required()
                ->live(),

            TextInput::make('age_range')
                ->label('Rango de edad')
                ->placeholder('Ej: 15-24')
                ->required()
                ->live()
                ->rules(function (Get $get, $record) {
                    $parentId = $this->getOwnerRecord()->getKey();

                    $rule = Rule::unique('employment_demographics', 'age_range')
                        ->where(
                            fn($q) => $q
                                ->where('tourism_employment_id', $parentId)
                                ->where('gender', $get('gender'))
                        );

                    if ($record) {
                        $rule->ignore($record->getKey());
                    }

                    return [$rule];
                })
                ->validationMessages([
                    'unique' => 'Ya existe una fila para ese Género y Rango de edad en este Empleo.',
                ]),

            TextInput::make('people_count')
                ->label('Cantidad de personas')
                ->required()
                ->numeric()
                ->minValue(0),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('age_range')
            ->columns([
                TextColumn::make('gender')
                    ->formatStateUsing(function ($state): string {
                        // Si llega como enum (BackedEnum o UnitEnum)
                        if ($state instanceof BackedEnum) {
                            return match ($state->value) {
                                'male' => 'Masculino',
                                'female' => 'Femenino',
                                default => ucfirst((string) $state->value),
                            };
                        }

                        if ($state instanceof UnitEnum) {
                            return ucfirst($state->name);
                        }

                        // Si llega como string desde DB
                        if (is_string($state)) {
                            return match ($state) {
                                'male' => 'Masculino',
                                'female' => 'Femenino',
                                default => ucfirst($state),
                            };
                        }

                        return '-';
                    }),

                TextColumn::make('age_range')
                    ->label('Rango de edad')
                    ->searchable(),

                TextColumn::make('people_count')
                    ->label('Personas')
                    ->numeric()
                    ->sortable(),
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                DeleteBulkAction::make(),
            ]);
    }
}
