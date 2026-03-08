<div class="space-y-6">
    <div>
        <h2 class="text-base font-semibold text-gray-900">Alojamientos turísticos</h2>
        <p class="mt-1 text-sm text-gray-500">
            Indicadores, capacidad y desempeño del sector de alojamientos.
        </p>
    </div>

    {{-- KPIs --}}
    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <livewire:public-interface.kpi-card
            :key="'accommodation-establishments-'.$year.'-'.$month"
            title="Establecimientos"
            :value="number_format($kpis['establishments'] ?? 0, 0, ',', '.')"
            badge="Observado"
            helpText="Cantidad total registrada"
        />

        <livewire:public-interface.kpi-card
            :key="'accommodation-rooms-'.$year.'-'.$month"
            title="Habitaciones"
            :value="number_format($kpis['rooms'] ?? 0, 0, ',', '.')"
            badge="Observado"
            helpText="Capacidad instalada total"
        />

        <livewire:public-interface.kpi-card
            :key="'accommodation-beds-'.$year.'-'.$month"
            title="Camas"
            :value="number_format($kpis['beds'] ?? 0, 0, ',', '.')"
            badge="Observado"
            helpText="Capacidad instalada total"
        />

        <livewire:public-interface.kpi-card
            :key="'accommodation-occupancy-average-'.$year.'-'.$month"
            title="Ocupación promedio"
            :value="number_format($kpis['occupancy_average'] ?? 0, 2, ',', '.')"
            unit="%"
            badge="Observado"
            helpText="Promedio según filtros aplicados"
        />
    </div>

    {{-- Desempeño --}}
    <div class="grid gap-4 lg:grid-cols-2">
        <div wire:key="accommodation-occupancy-by-month-{{ $year ?? 'null' }}">
            <x-chart.card
                title="Ocupación por mes"
                subtitle="Serie mensual de ocupación"
                :chart-id="'accommodation-occupancy-by-month-'.($year ?? 'null')"
                type="line"
                :labels="$occupancyByMonth['labels'] ?? []"
                :datasets="[
                    [
                        'label' => 'Ocupación (%)',
                        'data' => $occupancyByMonth['data'] ?? [],
                        'borderWidth' => 2,
                        'tension' => 0.3,
                    ]
                ]"
            />
        </div>

        <div wire:key="accommodation-by-category-{{ $year ?? 'null' }}-{{ $month ?? 'all' }}">
            <x-chart.card
                title="Distribución por categoría"
                subtitle="Capacidad por tipo/categoría"
                :chart-id="'accommodation-by-category-'.($year ?? 'null').'-'.($month ?? 'all')"
                type="bar"
                :labels="$byCategory['labels'] ?? []"
                :datasets="[
                    [
                        'label' => 'Establecimientos',
                        'data' => $byCategory['data'] ?? [],
                        'borderWidth' => 1,
                    ]
                ]"
            />
        </div>
    </div>

    <div class="grid gap-4 lg:grid-cols-2">
        <div wire:key="accommodation-occupancy-yoy-{{ $year ?? 'null' }}">
            <x-chart.card
                title="Ocupación interanual"
                subtitle="Comparación año seleccionado vs anterior"
                :chart-id="'accommodation-occupancy-yoy-'.($year ?? 'null')"
                type="line"
                :labels="$occupancyYoYByMonth['labels'] ?? []"
                :datasets="[
                    [
                        'label' => 'Año actual '.($occupancyYoYByMonth['current_year'] ?? ''),
                        'data' => $occupancyYoYByMonth['current'] ?? [],
                        'borderWidth' => 2,
                        'tension' => 0.3,
                    ],
                    [
                        'label' => 'Año anterior '.($occupancyYoYByMonth['previous_year'] ?? ''),
                        'data' => $occupancyYoYByMonth['previous'] ?? [],
                        'borderWidth' => 2,
                        'borderDash' => [5, 5],
                        'tension' => 0.3,
                    ]
                ]"
            />
        </div>

        <div wire:key="accommodation-season-vs-occupancy-{{ $year ?? 'null' }}-{{ $month ?? 'all' }}">
            <x-chart.card
                title="Temporada vs ocupación"
                subtitle="Promedio de ocupación por temporada"
                :chart-id="'accommodation-season-vs-occupancy-'.($year ?? 'null').'-'.($month ?? 'all')"
                type="bar"
                :labels="$seasonVsOccupancy['labels'] ?? []"
                :datasets="[
                    [
                        'label' => 'Ocupación (%)',
                        'data' => $seasonVsOccupancy['data'] ?? [],
                        'borderWidth' => 1,
                    ]
                ]"
            />
        </div>
    </div>

    {{-- Capacidad --}}
    <div class="grid gap-4 lg:grid-cols-2">
        <div wire:key="accommodation-installed-capacity-by-month-{{ $year ?? 'null' }}">
            <x-chart.card
                title="Capacidad instalada por mes"
                subtitle="Referencia mensual de camas instaladas"
                :chart-id="'accommodation-installed-capacity-by-month-'.($year ?? 'null')"
                type="line"
                :labels="$installedCapacityByMonth['labels'] ?? []"
                :datasets="[
                    [
                        'label' => 'Camas',
                        'data' => $installedCapacityByMonth['data'] ?? [],
                        'borderWidth' => 2,
                        'tension' => 0.3,
                    ]
                ]"
            />
        </div>

        <div wire:key="accommodation-available-rooms-by-month-{{ $year ?? 'null' }}">
            <x-chart.card
                title="Habitaciones disponibles por mes"
                subtitle="Referencia mensual de habitaciones instaladas"
                :chart-id="'accommodation-available-rooms-by-month-'.($year ?? 'null')"
                type="line"
                :labels="$availableRoomsByMonth['labels'] ?? []"
                :datasets="[
                    [
                        'label' => 'Habitaciones',
                        'data' => $availableRoomsByMonth['data'] ?? [],
                        'borderWidth' => 2,
                        'tension' => 0.3,
                    ]
                ]"
            />
        </div>
    </div>

    <div wire:key="accommodation-installed-capacity-by-department-{{ $year ?? 'null' }}-{{ $month ?? 'all' }}">
        <x-chart.card
            title="Capacidad por departamento"
            subtitle="Distribución territorial de camas instaladas"
            :chart-id="'accommodation-installed-capacity-by-department-'.($year ?? 'null').'-'.($month ?? 'all')"
            type="bar"
            :labels="$installedCapacityByDepartment['labels'] ?? []"
            :datasets="[
                [
                    'label' => 'Camas',
                    'data' => $installedCapacityByDepartment['data'] ?? [],
                    'borderWidth' => 1,
                ]
            ]"
            :height="360"
        />
    </div>
</div>
