<div class="public-section public-section-spacing">
    <div class="public-section-header">
        <h2 class="public-section-title">Alojamientos turísticos</h2>
        <p class="public-section-description">
            Indicadores, capacidad instalada y desempeño del sector de alojamientos.
        </p>
    </div>

    {{-- KPIs --}}
    <div class="public-four-column-grid">
        <livewire:public-interface.kpi-card
            :key="'accommodation-establishments-' . $year . '-' . $month"
            title="Establecimientos"
            :value="number_format($kpis['establishments'] ?? 0, 0, ',', '.')"
            badge="Observado"
            helpText="Cantidad total registrada"
        />

        <livewire:public-interface.kpi-card
            :key="'accommodation-rooms-' . $year . '-' . $month"
            title="Habitaciones"
            :value="number_format($kpis['rooms'] ?? 0, 0, ',', '.')"
            badge="Observado"
            helpText="Capacidad instalada total"
        />

        <livewire:public-interface.kpi-card
            :key="'accommodation-beds-' . $year . '-' . $month"
            title="Camas"
            :value="number_format($kpis['beds'] ?? 0, 0, ',', '.')"
            badge="Observado"
            helpText="Capacidad instalada total"
        />

        <livewire:public-interface.kpi-card
            :key="'accommodation-occupancy-average-' . $year . '-' . $month"
            title="Ocupación promedio"
            :value="number_format($kpis['occupancy_average'] ?? 0, 2, ',', '.')"
            unit="%"
            badge="Observado"
            helpText="Promedio según filtros aplicados"
        />
    </div>

    <div class="public-two-column-grid">
        <div wire:key="accommodation-occupancy-by-month-{{ $year ?? 'null' }}">
            <x-chart.card
                title="Ocupación por mes"
                subtitle="Serie mensual de ocupación"
                :chart-id="'accommodation-occupancy-by-month-' . ($year ?? 'null')"
                type="line"
                bodyClass="public-chart-standard"
                :labels="$occupancyByMonth['labels'] ?? []"
                :datasets="[
                    [
                        'label' => 'Ocupación (%)',
                        'data' => $occupancyByMonth['data'] ?? [],
                        'borderWidth' => 2,
                        'tension' => 0.3,
                    ],
                ]"
            />
        </div>

        <div wire:key="accommodation-by-category-{{ $year ?? 'null' }}-{{ $month ?? 'all' }}">
            <x-chart.card
                title="Distribución por categoría"
                subtitle="Establecimientos por categoría"
                :chart-id="'accommodation-by-category-' . ($year ?? 'null') . '-' . ($month ?? 'all')"
                type="bar"
                bodyClass="public-chart-standard"
                :labels="$byCategory['labels'] ?? []"
                :datasets="[
                    [
                        'label' => 'Establecimientos',
                        'data' => $byCategory['data'] ?? [],
                        'borderWidth' => 1,
                    ],
                ]"
            />
        </div>
    </div>

    <div class="public-two-column-grid">
        <div wire:key="accommodation-occupancy-yoy-{{ $year ?? 'null' }}">
            <x-chart.card
                title="Ocupación interanual"
                subtitle="Comparación año seleccionado vs año anterior"
                :chart-id="'accommodation-occupancy-yoy-' . ($year ?? 'null')"
                type="line"
                bodyClass="public-chart-standard"
                :labels="$occupancyYoYByMonth['labels'] ?? []"
                :datasets="[
                    [
                        'label' => 'Año actual ' . ($occupancyYoYByMonth['current_year'] ?? ''),
                        'data' => $occupancyYoYByMonth['current'] ?? [],
                        'borderWidth' => 2,
                        'tension' => 0.3,
                    ],
                    [
                        'label' => 'Año anterior ' . ($occupancyYoYByMonth['previous_year'] ?? ''),
                        'data' => $occupancyYoYByMonth['previous'] ?? [],
                        'borderWidth' => 2,
                        'borderDash' => [5, 5],
                        'tension' => 0.3,
                    ],
                ]"
            />
        </div>

        <div wire:key="accommodation-season-vs-occupancy-{{ $year ?? 'null' }}-{{ $month ?? 'all' }}">
            <x-chart.card
                title="Temporada vs ocupación"
                subtitle="Promedio de ocupación por temporada"
                :chart-id="'accommodation-season-vs-occupancy-' . ($year ?? 'null') . '-' . ($month ?? 'all')"
                type="bar"
                bodyClass="public-chart-standard"
                :labels="$seasonVsOccupancy['labels'] ?? []"
                :datasets="[
                    [
                        'label' => 'Ocupación (%)',
                        'data' => $seasonVsOccupancy['data'] ?? [],
                        'borderWidth' => 1,
                    ],
                ]"
            />
        </div>
    </div>

    <div wire:key="accommodation-capacity-by-department-{{ $year ?? 'null' }}-{{ $month ?? 'all' }}">
        <x-chart.card
            title="Capacidad por departamento"
            subtitle="Distribución territorial de camas instaladas"
            :chart-id="'accommodation-capacity-by-department-' . ($year ?? 'null') . '-' . ($month ?? 'all')"
            type="bar"
            bodyClass="public-chart-tall"
            :labels="$capacityByDepartment['labels'] ?? []"
            :datasets="[
                [
                    'label' => 'Camas',
                    'data' => $capacityByDepartment['data'] ?? [],
                    'borderWidth' => 1,
                ],
            ]"
            :height="360"
        />
    </div>
</div>
