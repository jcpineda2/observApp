<div class="public-section public-section-spacing">
    <section class="space-y-6">
        <x-public.ui.section-heading
            eyebrow="Observatorio Turístico"
            title="Turismo interno"
            description="Indicadores, aperturas y composición del turismo interno."
        />

        <div class="flex flex-wrap items-center gap-3">
            <x-public.ui.active-period
                :year-label="$this->activeYearLabel"
                :month-label="$this->activeMonthLabel"
            />
        </div>

        <x-public.ui.metric-note
            text="Los indicadores combinan valores observados del período con referencias fijas para gasto y estadía promedio. Las series mensuales se presentan para el año seleccionado."
        />

        <livewire:public.global-filters />

        <div class="relative space-y-6">

            {{-- KPIs principales del PDF --}}
            <div class="public-four-column-grid">
                <x-public.ui.kpi-card
                    title="Turistas internos"
                    :value="number_format($kpis['tourists'] ?? 0, 0, ',', '.')"
                    badge="Observado"
                    help-text="Cantidad total según filtros aplicados."
                />

                <x-public.ui.kpi-card
                    title="Gasto turístico interno"
                    :value="isset($kpis['fixed_avg_spend']) && $kpis['fixed_avg_spend'] !== null
                        ? number_format($kpis['fixed_avg_spend'], 2, ',', '.') . (!empty($kpis['fixed_avg_spend_unit']) ? ' ' . $kpis['fixed_avg_spend_unit'] : '')
                        : '-'"
                    badge="Dato fijo"
                    :help-text="!empty($kpis['fixed_avg_spend_source'])
                        ? 'Valor fijo de referencia. Fuente: ' . $kpis['fixed_avg_spend_source']
                        : 'Valor fijo de referencia.'"
                />

                <x-public.ui.kpi-card
                    title="Estadía promedio"
                    :value="isset($kpis['fixed_avg_stay']) && $kpis['fixed_avg_stay'] !== null
                        ? number_format($kpis['fixed_avg_stay'], 2, ',', '.') . (!empty($kpis['fixed_avg_stay_unit']) ? ' ' . $kpis['fixed_avg_stay_unit'] : '')
                        : '-'"
                    badge="Dato fijo"
                    :help-text="!empty($kpis['fixed_avg_stay_source'])
                        ? 'Valor fijo de referencia. Fuente: ' . $kpis['fixed_avg_stay_source']
                        : 'Valor fijo de referencia.'"
                />

                <x-public.ui.kpi-card
                    title="Componentes del gasto"
                    :value="number_format(count($fixedComposition['items'] ?? []), 0, ',', '.')"
                    badge="Dato fijo"
                    help-text="Categorías de composición disponibles."
                />
            </div>

            {{-- Composición fija del gasto --}}
            <div class="public-two-column-grid">
                <div wire:key="domestic-fixed-composition-chart-{{ $year ?? 'null' }}">
                    @if (count($fixedComposition['labels'] ?? []))
                        <x-chart.card
                            title="Composición del gasto"
                            subtitle="Distribución fija del gasto turístico interno"
                            :chart-id="'domestic-fixed-composition-chart-' . ($year ?? 'null')"
                            type="doughnut"
                            bodyClass="public-chart-standard"
                            :labels="$fixedComposition['labels'] ?? []"
                            :datasets="[
                                [
                                    'label' => 'Composición (%)',
                                    'data' => $fixedComposition['data'] ?? [],
                                ],
                            ]"
                        />
                    @else
                        <x-public.states.no-data
                            title="Sin composición disponible"
                            message="No hay composición fija cargada para el año seleccionado."
                        />
                    @endif
                </div>

                <div class="ui-surface p-5 sm:p-6">
                    <div class="space-y-1">
                        <h3 class="ui-heading text-base">Detalle de composición</h3>
                        <p class="ui-text-muted text-sm">
                            Valores fijos de referencia para la distribución del gasto.
                        </p>
                    </div>

                    <div class="mt-5 space-y-3">
                        @forelse (($fixedComposition['items'] ?? []) as $item)
                            <div class="rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 dark:border-slate-700 dark:bg-slate-800/60">
                                <div class="flex items-center justify-between gap-4">
                                    <div class="min-w-0">
                                        <p class="truncate text-sm font-medium text-gray-900 dark:text-slate-100">
                                            {{ $item['label'] }}
                                        </p>

                                        <p class="mt-1 text-xs text-gray-500 dark:text-slate-400">
                                            {{ $item['source'] ?? 'Sin fuente' }}
                                        </p>
                                    </div>

                                    <div class="shrink-0 text-sm font-semibold text-gray-800 dark:text-slate-200">
                                        {{ number_format($item['value'] ?? 0, 2, ',', '.') }}{{ !empty($item['unit']) ? ' ' . $item['unit'] : '' }}
                                    </div>
                                </div>
                            </div>
                        @empty
                            <x-public.states.no-data
                                title="Sin detalle de composición"
                                message="No hay composición fija cargada para el año seleccionado."
                            />
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- Aperturas y observados --}}
            <div class="public-two-column-grid">
                <div wire:key="domestic-tourists-by-month-{{ $year ?? 'null' }}">
                    @if (count($touristsByMonth['labels'] ?? []))
                        <x-chart.card
                            title="Turistas por mes"
                            subtitle="Serie mensual de turistas internos"
                            :chart-id="'domestic-tourists-by-month-' . ($year ?? 'null')"
                            type="line"
                            bodyClass="public-chart-standard"
                            :labels="$touristsByMonth['labels'] ?? []"
                            :datasets="[
                                [
                                    'label' => 'Turistas internos',
                                    'data' => $touristsByMonth['data'] ?? [],
                                    'borderWidth' => 2,
                                    'tension' => 0.3,
                                ],
                            ]"
                        />
                    @else
                        <x-public.states.no-data
                            title="Sin turistas por mes"
                            message="No existen registros mensuales para el año seleccionado."
                        />
                    @endif
                </div>

                <div wire:key="domestic-spend-observed-by-month-{{ $year ?? 'null' }}">
                    @if (count($spendObservedByMonth['labels'] ?? []))
                        <x-chart.card
                            title="Gasto observado por mes"
                            subtitle="Serie mensual del gasto observado"
                            :chart-id="'domestic-spend-observed-by-month-' . ($year ?? 'null')"
                            type="bar"
                            bodyClass="public-chart-standard"
                            :labels="$spendObservedByMonth['labels'] ?? []"
                            :datasets="[
                                [
                                    'label' => 'Gasto observado',
                                    'data' => $spendObservedByMonth['data'] ?? [],
                                    'borderWidth' => 1,
                                ],
                            ]"
                        />
                    @else
                        <x-public.states.no-data
                            title="Sin gasto observado"
                            message="No existen registros de gasto observado para el año seleccionado."
                        />
                    @endif
                </div>
            </div>

            <div class="public-two-column-grid">
                <div wire:key="domestic-average-stay-observed-by-month-{{ $year ?? 'null' }}">
                    @if (count($averageStayObservedByMonth['labels'] ?? []))
                        <x-chart.card
                            title="Estadía observada por mes"
                            subtitle="Serie mensual de estadía promedio observada"
                            :chart-id="'domestic-average-stay-observed-by-month-' . ($year ?? 'null')"
                            type="line"
                            bodyClass="public-chart-standard"
                            :labels="$averageStayObservedByMonth['labels'] ?? []"
                            :datasets="[
                                [
                                    'label' => 'Estadía observada',
                                    'data' => $averageStayObservedByMonth['data'] ?? [],
                                    'borderWidth' => 2,
                                    'tension' => 0.3,
                                ],
                            ]"
                        />
                    @else
                        <x-public.states.no-data
                            title="Sin estadía observada"
                            message="No existen registros de estadía observada para el año seleccionado."
                        />
                    @endif
                </div>

                <div wire:key="domestic-by-destination-department-{{ $year ?? 'null' }}-{{ $month ?? 'all' }}">
                    @if (count($byDestinationDepartment['labels'] ?? []))
                        <x-chart.card
                            title="Departamento destino"
                            subtitle="Top departamentos destino"
                            :chart-id="'domestic-by-destination-department-' . ($year ?? 'null') . '-' . ($month ?? 'all')"
                            type="bar"
                            bodyClass="public-chart-standard"
                            :labels="$byDestinationDepartment['labels'] ?? []"
                            :datasets="[
                                [
                                    'label' => 'Turistas internos',
                                    'data' => $byDestinationDepartment['data'] ?? [],
                                    'borderWidth' => 1,
                                ],
                            ]"
                        />
                    @else
                        <x-public.states.no-data
                            title="Sin departamentos destino"
                            message="No existen registros por departamento destino para el período seleccionado."
                        />
                    @endif
                </div>
            </div>

            <div class="public-two-column-grid">
                <div wire:key="domestic-by-origin-region-{{ $year ?? 'null' }}-{{ $month ?? 'all' }}">
                    @if (count($byOriginRegion['labels'] ?? []))
                        <x-chart.card
                            title="Región de origen"
                            subtitle="Distribución por región de origen"
                            :chart-id="'domestic-by-origin-region-' . ($year ?? 'null') . '-' . ($month ?? 'all')"
                            type="doughnut"
                            bodyClass="public-chart-standard"
                            :labels="$byOriginRegion['labels'] ?? []"
                            :datasets="[
                                [
                                    'label' => 'Turistas internos',
                                    'data' => $byOriginRegion['data'] ?? [],
                                ],
                            ]"
                        />
                    @else
                        <x-public.states.no-data
                            title="Sin regiones de origen"
                            message="No existen registros por región de origen para el período seleccionado."
                        />
                    @endif
                </div>

                <div wire:key="domestic-by-travel-reason-{{ $year ?? 'null' }}-{{ $month ?? 'all' }}">
                    @if (count($byTravelReason['labels'] ?? []))
                        <x-chart.card
                            title="Motivo de viaje"
                            subtitle="Distribución por motivo"
                            :chart-id="'domestic-by-travel-reason-' . ($year ?? 'null') . '-' . ($month ?? 'all')"
                            type="bar"
                            bodyClass="public-chart-standard"
                            :labels="$byTravelReason['labels'] ?? []"
                            :datasets="[
                                [
                                    'label' => 'Turistas internos',
                                    'data' => $byTravelReason['data'] ?? [],
                                    'borderWidth' => 1,
                                ],
                            ]"
                        />
                    @else
                        <x-public.states.no-data
                            title="Sin motivos de viaje"
                            message="No existen registros por motivo de viaje para el período seleccionado."
                        />
                    @endif
                </div>
            </div>
        </div>
    </section>
</div>
