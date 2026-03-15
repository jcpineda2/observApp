<div
    class="public-section public-section-spacing"
    x-data
    x-on:paraguay-map:department-selected.window="$wire.selectDepartment($event.detail.department)"
>

    <x-public.ui.section-heading
        title="Turismo receptivo"
        description="Indicadores, aperturas y visualizaciones del turismo receptivo."
    />

    <livewire:public.global-filters />

    {{-- KPIs --}}
    <div class="public-kpi-grid">
        <x-public.ui.kpi-card
            :key="'inbound-tourists-' . $year . '-' . $month"
            title="Llegadas de turistas"
            :value="number_format($kpis['tourists'] ?? 0, 0, ',', '.')"
            badge="Observado"
            helpText="Total según filtros aplicados"
        />

        <x-public.ui.kpi-card
            :key="'inbound-excursionists-' . $year . '-' . $month"
            title="Llegadas de excursionistas"
            :value="number_format($kpis['excursionists'] ?? 0, 0, ',', '.')"
            badge="Observado"
            helpText="Visitantes sin pernocte"
        />

        <x-public.ui.kpi-card
            :key="'inbound-foreign-exchange-' . $year . '-' . $month"
            title="Ingresos de divisas"
            :value="number_format($kpis['foreign_exchange_revenue'] ?? 0, 2, ',', '.')"
            unit="USD"
            badge="Observado"
            helpText="Suma según registros cargados"
        />

        <x-public.ui.kpi-card
            :key="'inbound-fixed-average-spend-' . $year"
            title="Gasto promedio"
            :value="isset($kpis['fixed_average_spend']) && $kpis['fixed_average_spend'] !== null
                ? number_format($kpis['fixed_average_spend'], 2, ',', '.')
                : '-'"
            :unit="$kpis['fixed_average_spend_unit'] ?? null"
            badge="Dato fijo"
            :source="$kpis['fixed_average_spend_source'] ?? null"
            helpText="Valor oficial de referencia"
        />

        <x-public.ui.kpi-card
            :key="'inbound-fixed-average-stay-' . $year"
            title="Estadía promedio"
            :value="isset($kpis['fixed_average_stay']) && $kpis['fixed_average_stay'] !== null
                ? number_format($kpis['fixed_average_stay'], 2, ',', '.')
                : '-'"
            :unit="$kpis['fixed_average_stay_unit'] ?? null"
            badge="Dato fijo"
            :source="$kpis['fixed_average_stay_source'] ?? null"
            helpText="Valor oficial de referencia"
        />
    </div>

    {{-- Aperturas principales --}}
    <div class="public-two-column-grid">
        <div wire:key="inbound-by-month-{{ $year ?? 'null' }}">
            <x-chart.card
                title="Llegadas por mes"
                subtitle="Apertura mensual del turismo receptivo"
                :chart-id="'inbound-by-month-' . ($year ?? 'null')"
                type="line"
                bodyClass="public-chart-standard"
                :labels="$byMonth['labels'] ?? []"
                :datasets="[
                    [
                        'label' => 'Llegadas de turistas',
                        'data' => $byMonth['data'] ?? [],
                        'borderWidth' => 2,
                        'tension' => 0.3,
                    ],
                ]"
            />
        </div>

        <div wire:key="inbound-by-country-{{ $year ?? 'null' }}-{{ $month ?? 'all' }}">
            <x-chart.card
                title="País de residencia"
                subtitle="Distribución por país"
                :chart-id="'inbound-by-country-' . ($year ?? 'null') . '-' . ($month ?? 'all')"
                type="bar"
                bodyClass="public-chart-standard"
                :labels="$byCountry['labels'] ?? []"
                :datasets="[
                    [
                        'label' => 'Llegadas de turistas',
                        'data' => $byCountry['data'] ?? [],
                        'borderWidth' => 1,
                    ],
                ]"
            />
        </div>
    </div>

    <div class="public-two-column-grid">
        <div wire:key="inbound-by-entry-mode-{{ $year ?? 'null' }}-{{ $month ?? 'all' }}">
            <x-chart.card
                title="Vía de ingreso"
                subtitle="Aérea, terrestre y fluvial/marítima"
                :chart-id="'inbound-by-entry-mode-' . ($year ?? 'null') . '-' . ($month ?? 'all')"
                type="doughnut"
                bodyClass="public-chart-standard"
                :labels="$byEntryMode['labels'] ?? []"
                :datasets="[
                    [
                        'label' => 'Llegadas',
                        'data' => $byEntryMode['data'] ?? [],
                    ],
                ]"
            />
        </div>

        <div wire:key="inbound-by-travel-reason-{{ $year ?? 'null' }}-{{ $month ?? 'all' }}">
            <x-chart.card
                title="Motivo de viaje"
                subtitle="Distribución por motivo"
                :chart-id="'inbound-by-travel-reason-' . ($year ?? 'null') . '-' . ($month ?? 'all')"
                type="bar"
                bodyClass="public-chart-standard"
                :labels="$byTravelReason['labels'] ?? []"
                :datasets="[
                    [
                        'label' => 'Llegadas de turistas',
                        'data' => $byTravelReason['data'] ?? [],
                        'borderWidth' => 1,
                    ],
                ]"
            />
        </div>
    </div>

    {{-- Visualizaciones --}}
    <div class="public-two-column-grid">
        <div wire:key="inbound-top-markets-{{ $year ?? 'null' }}-{{ $month ?? 'all' }}">
            <x-chart.card
                title="Ranking de mercados emisores"
                subtitle="Top 10 países con mayor emisión"
                :chart-id="'inbound-top-markets-' . ($year ?? 'null') . '-' . ($month ?? 'all')"
                type="bar"
                bodyClass="public-chart-standard"
                :labels="$topMarkets['labels'] ?? []"
                :datasets="[
                    [
                        'label' => 'Llegadas de turistas',
                        'data' => $topMarkets['data'] ?? [],
                        'borderWidth' => 1,
                    ],
                ]"
            />
        </div>

        <div wire:key="inbound-yoy-{{ $year ?? 'null' }}">
            <x-chart.card
                title="Evolución interanual"
                subtitle="Comparación año seleccionado vs año anterior"
                :chart-id="'inbound-yoy-' . ($year ?? 'null')"
                type="line"
                bodyClass="public-chart-standard"
                :labels="$yoy['labels'] ?? []"
                :datasets="[
                    [
                        'label' => 'Año actual ' . ($yoy['current_year'] ?? ''),
                        'data' => $yoy['current'] ?? [],
                        'borderWidth' => 2,
                        'tension' => 0.3,
                    ],
                    [
                        'label' => 'Año anterior ' . ($yoy['previous_year'] ?? ''),
                        'data' => $yoy['previous'] ?? [],
                        'borderWidth' => 2,
                        'borderDash' => [5, 5],
                        'tension' => 0.3,
                    ],
                ]"
            />
        </div>
    </div>

    {{-- Mapa geográfico --}}
    <div class="public-map-wrapper">
        <x-map.paraguay-departments
            :map-id="$mapId"
            :geo-json-url="asset('geo/paraguay-departamentos.json')"
            :values="$mapByDepartment ?? []"
            title="Mapa geográfico"
            subtitle="Distribución territorial del turismo receptivo por departamento destino"
            :height="420"
        />

        @if ($selectedDepartment)
            <div class="public-info-banner">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h3 class="public-info-banner-title">
                            Departamento seleccionado: {{ $selectedDepartmentLabel }}
                        </h3>
                        <p class="public-info-banner-text">
                            Los indicadores siguientes están filtrados por el departamento seleccionado en el mapa.
                        </p>
                    </div>

                    <button
                        type="button"
                        wire:click="clearSelectedDepartment"
                        class="ui-btn-secondary"
                    >
                        Limpiar selección
                    </button>
                </div>
            </div>

            <div class="public-three-column-grid">
                <x-public.ui.kpi-card
                    :key="'selected-department-tourists-' . $selectedDepartment . '-' . $year . '-' . $month"
                    title="Turistas del departamento"
                    :value="number_format($selectedDepartmentSummary['tourists'] ?? 0, 0, ',', '.')"
                    badge="Mapa"
                    helpText="Llegadas de turistas en el departamento seleccionado"
                />

                <x-public.ui.kpi-card
                    :key="'selected-department-excursionists-' . $selectedDepartment . '-' . $year . '-' . $month"
                    title="Excursionistas del departamento"
                    :value="number_format($selectedDepartmentSummary['excursionists'] ?? 0, 0, ',', '.')"
                    badge="Mapa"
                    helpText="Llegadas de excursionistas en el departamento seleccionado"
                />

                <x-public.ui.kpi-card
                    :key="'selected-department-revenue-' . $selectedDepartment . '-' . $year . '-' . $month"
                    title="Divisas del departamento"
                    :value="number_format($selectedDepartmentSummary['foreign_exchange_revenue'] ?? 0, 2, ',', '.')"
                    unit="USD"
                    badge="Mapa"
                    helpText="Ingresos de divisas del departamento seleccionado"
                />
            </div>

            <div wire:key="selected-department-by-country-{{ $selectedDepartment }}-{{ $year ?? 'null' }}-{{ $month ?? 'all' }}">
                <x-chart.card
                    title="País de residencia del departamento seleccionado"
                    subtitle="Top 10 países asociados al departamento elegido en el mapa"
                    :chart-id="'selected-department-by-country-' .
                        ($selectedDepartment ?? 'none') .
                        '-' .
                        ($year ?? 'null') .
                        '-' .
                        ($month ?? 'all')"
                    type="bar"
                    bodyClass="public-chart-standard"
                    :labels="$selectedDepartmentByCountry['labels'] ?? []"
                    :datasets="[
                        [
                            'label' => 'Llegadas de turistas',
                            'data' => $selectedDepartmentByCountry['data'] ?? [],
                            'borderWidth' => 1,
                        ],
                    ]"
                />
            </div>
        @endif
    </div>
</div>
