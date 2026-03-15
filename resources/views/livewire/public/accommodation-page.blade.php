<div class="public-section public-section-spacing">
    <section class="space-y-6">
        <x-public.ui.section-heading
            eyebrow="Observatorio Turístico"
            title="Alojamientos turísticos"
            description="Indicadores, capacidad instalada y desempeño del sector de alojamientos."
        />

        <div class="flex flex-wrap items-center gap-3">
            <x-public.ui.active-period
                :year-label="$this->activeYearLabel"
                :month-label="$this->activeMonthLabel"
            />
        </div>

        <x-public.ui.metric-note
            text="La ocupación promedio se calcula con base en los registros del período filtrado. La capacidad instalada corresponde al stock registrado de establecimientos, habitaciones y camas."
        />

        <livewire:public.global-filters />

        <div class="relative space-y-6">


            {{-- KPIs --}}
            <div class="public-four-column-grid">
                <x-public.ui.kpi-card
                    title="Establecimientos"
                    :value="number_format($kpis['establishments'] ?? 0, 0, ',', '.')"
                    badge="Observado"
                    help-text="Cantidad total registrada."
                />

                <x-public.ui.kpi-card
                    title="Habitaciones"
                    :value="number_format($kpis['rooms'] ?? 0, 0, ',', '.')"
                    badge="Observado"
                    help-text="Capacidad instalada total."
                />

                <x-public.ui.kpi-card
                    title="Camas"
                    :value="number_format($kpis['beds'] ?? 0, 0, ',', '.')"
                    badge="Observado"
                    help-text="Capacidad instalada total."
                />

                <x-public.ui.kpi-card
                    title="Ocupación promedio"
                    :value="number_format($kpis['occupancy_average'] ?? 0, 2, ',', '.') . '%'"
                    badge="Indicador"
                    help-text="Promedio según filtros aplicados."
                />
            </div>

            <div class="public-two-column-grid">
                <div wire:key="accommodation-occupancy-by-month-{{ $year ?? 'null' }}">
                    @if (count($occupancyByMonth['labels'] ?? []))
                        <x-chart.card
                            title="Ocupación por mes"
                            subtitle="Serie mensual de ocupación para el año seleccionado"
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
                    @else
                        <x-public.states.no-data
                            title="Sin ocupación mensual disponible"
                            message="No existen registros de ocupación para el año seleccionado."
                        />
                    @endif
                </div>

                <div wire:key="accommodation-by-category-{{ $year ?? 'null' }}-{{ $month ?? 'all' }}">
                    @if (count($byCategory['labels'] ?? []))
                        <x-chart.card
                            title="Distribución por categoría"
                            subtitle="Establecimientos por categoría registrada"
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
                    @else
                        <x-public.states.no-data
                            title="Sin categorías disponibles"
                            message="No existen registros de categorías para el período seleccionado."
                        />
                    @endif
                </div>
            </div>

            <div class="public-two-column-grid">
                <div wire:key="accommodation-occupancy-yoy-{{ $year ?? 'null' }}">
                    @if (count($occupancyYoYByMonth['labels'] ?? []))
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
                    @else
                        <x-public.states.no-data
                            title="Sin comparativo interanual"
                            message="No existen datos suficientes para comparar el año seleccionado con el anterior."
                        />
                    @endif
                </div>

                <div wire:key="accommodation-season-vs-occupancy-{{ $year ?? 'null' }}-{{ $month ?? 'all' }}">
                    @if (count($seasonVsOccupancy['labels'] ?? []))
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
                    @else
                        <x-public.states.no-data
                            title="Sin datos por temporada"
                            message="No existen registros por temporada para el período seleccionado."
                        />
                    @endif
                </div>
            </div>

            <div wire:key="accommodation-capacity-by-department-{{ $year ?? 'null' }}-{{ $month ?? 'all' }}">
                @if (count($capacityByDepartment['labels'] ?? []))
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
                @else
                    <x-public.states.no-data
                        title="Sin capacidad territorial disponible"
                        message="No existen registros de capacidad por departamento para el período seleccionado."
                    />
                @endif
            </div>
        </div>
    </section>
</div>
