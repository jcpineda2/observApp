<?php

namespace App\Filament\Resources\AirConnectivityRoutes\Tables;

use App\Models\City;
use App\Models\Country;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class AirConnectivityRoutesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('year.year')->label('Año')->sortable(),
                TextColumn::make('month.month')->label('Mes')->sortable(),

                TextColumn::make('airLine.name')->label('Aerolínea')->sortable()->searchable(),

                TextColumn::make('originAirport.name')->label('Origen')->sortable()->searchable(),
                TextColumn::make('destinationAirport.name')->label('Destino')->sortable()->searchable(),

                TextColumn::make('destinationAirport.country.name')
                    ->label('País destino')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),

                TextColumn::make('destinationAirport.city.name')
                    ->label('Ciudad destino')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),

                IconColumn::make('is_active')
                    ->label('Activa')
                    ->boolean()
                    ->sortable(),

                TextColumn::make('flights_count')->label('Vuelos')->numeric()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('seats_count')->label('Asientos')->numeric()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('year_id')->label('Año')->relationship('year', 'year'),
                SelectFilter::make('month_id')->label('Mes')->relationship('month', 'month'),
                SelectFilter::make('air_line_id')->label('Aerolínea')->relationship('airLine', 'name'),

                // País destino
                SelectFilter::make('dest_country_id')
                    ->label('País destino')
                    ->options(fn () => Country::query()->orderBy('name')->pluck('name', 'id')->toArray())
                    ->query(function ($query, array $data) {
                        if (blank($data['value'] ?? null)) {
                            return $query;
                        }

                        return $query->whereHas('destinationAirport.country', fn ($q) => $q->where('id', $data['value']));
                    })
                    ->searchable(),

                // Ciudad destino
                SelectFilter::make('dest_city_id')
                    ->label('Ciudad destino')
                    ->options(fn () => City::query()->orderBy('name')->pluck('name', 'id')->toArray())
                    ->query(function ($query, array $data) {
                        if (blank($data['value'] ?? null)) {
                            return $query;
                        }

                        return $query->whereHas('destinationAirport.city', fn ($q) => $q->where('id', $data['value']));
                    })
                    ->searchable(),

                TernaryFilter::make('is_active')->label('Activa'),
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
