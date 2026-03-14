<div class="space-y-6">
    <div>
        <h2 class="text-base font-semibold text-gray-900">Turismo receptivo</h2>
        <p class="mt-1 text-sm text-gray-500">
            Indicadores, aperturas y visualizaciones del turismo receptivo.
        </p>
    </div>

    {{-- KPIs --}}
    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-5">
        <livewire:public-interface.kpi-card :key="'inbound-tourists-' . $year . '-' . $month" title="Llegadas de turistas" :value="number_format($kpis['tourists'] ?? 0, 0, ',', '.')"
            badge="Observado" helpText="Total según filtros aplicados" />

        <livewire:public-interface.kpi-card :key="'inbound-excursionists-' . $year . '-' . $month" title="Llegadas de excursionistas" :value="number_format($kpis['excursionists'] ?? 0, 0, ',', '.')"
            badge="Observado" helpText="Visitantes sin pernocte" />

        <livewire:public-interface.kpi-card :key="'inbound-foreign-exchange-' . $year . '-' . $month" title="Ingresos de divisas" :value="number_format($kpis['foreign_exchange_revenue'] ?? 0, 2, ',', '.')"
            unit="USD" badge="Observado" helpText="Suma según registros cargados" />

        <livewire:public-interface.kpi-card :key="'inbound-fixed-average-spend-' . $year" title="Gasto promedio" :value="isset($kpis['fixed_average_spend']) && $kpis['fixed_average_spend'] !== null
            ? number_format($kpis['fixed_average_spend'], 2, ',', '.')
            : '-'" :unit="$kpis['fixed_average_spend_unit'] ?? null"
            badge="Dato fijo" :source="$kpis['fixed_average_spend_source'] ?? null" helpText="Valor oficial de referencia" />

        <livewire:public-interface.kpi-card :key="'inbound-fixed-average-stay-' . $year" title="Estadía promedio" :value="isset($kpis['fixed_average_stay']) && $kpis['fixed_average_stay'] !== null
            ? number_format($kpis['fixed_average_stay'], 2, ',', '.')
            : '-'"
            :unit="$kpis['fixed_average_stay_unit'] ?? null" badge="Dato fijo" :source="$kpis['fixed_average_stay_source'] ?? null" helpText="Valor oficial de referencia" />
    </div>

    {{-- Aperturas principales --}}
    <div class="grid gap-4 lg:grid-cols-2">
        <div wire:key="inbound-by-month-{{ $year ?? 'null' }}">
            <x-chart.card title="Llegadas por mes" subtitle="Apertura mensual del turismo receptivo" :chart-id="'inbound-by-month-' . ($year ?? 'null')"
                type="line" :labels="$byMonth['labels'] ?? []" :datasets="[
                    [
                        'label' => 'Llegadas de turistas',
                        'data' => $byMonth['data'] ?? [],
                        'borderWidth' => 2,
                        'tension' => 0.3,
                    ],
                ]" />
        </div>

        <div wire:key="inbound-by-country-{{ $year ?? 'null' }}-{{ $month ?? 'all' }}">
            <x-chart.card title="País de residencia" subtitle="Distribución por país" :chart-id="'inbound-by-country-' . ($year ?? 'null') . '-' . ($month ?? 'all')" type="bar"
                :labels="$byCountry['labels'] ?? []" :datasets="[
                    [
                        'label' => 'Llegadas de turistas',
                        'data' => $byCountry['data'] ?? [],
                        'borderWidth' => 1,
                    ],
                ]" />
        </div>
    </div>

    <div class="grid gap-4 lg:grid-cols-2">
        <div wire:key="inbound-by-entry-mode-{{ $year ?? 'null' }}-{{ $month ?? 'all' }}">
            <x-chart.card title="Vía de ingreso" subtitle="Aérea, terrestre y fluvial/marítima" :chart-id="'inbound-by-entry-mode-' . ($year ?? 'null') . '-' . ($month ?? 'all')"
                type="doughnut" :labels="$byEntryMode['labels'] ?? []" :datasets="[
                    [
                        'label' => 'Llegadas',
                        'data' => $byEntryMode['data'] ?? [],
                    ],
                ]" />
        </div>

        <div wire:key="inbound-by-travel-reason-{{ $year ?? 'null' }}-{{ $month ?? 'all' }}">
            <x-chart.card title="Motivo de viaje" subtitle="Distribución por motivo" :chart-id="'inbound-by-travel-reason-' . ($year ?? 'null') . '-' . ($month ?? 'all')" type="bar"
                :labels="$byTravelReason['labels'] ?? []" :datasets="[
                    [
                        'label' => 'Llegadas de turistas',
                        'data' => $byTravelReason['data'] ?? [],
                        'borderWidth' => 1,
                    ],
                ]" />
        </div>
    </div>

    {{-- Visualizaciones --}}
    <div class="grid gap-4 lg:grid-cols-2">
        <div wire:key="inbound-top-markets-{{ $year ?? 'null' }}-{{ $month ?? 'all' }}">
            <x-chart.card title="Ranking de mercados emisores" subtitle="Top 10 países con mayor emisión"
                :chart-id="'inbound-top-markets-' . ($year ?? 'null') . '-' . ($month ?? 'all')" type="bar" :labels="$topMarkets['labels'] ?? []" :datasets="[
                    [
                        'label' => 'Llegadas de turistas',
                        'data' => $topMarkets['data'] ?? [],
                        'borderWidth' => 1,
                    ],
                ]" />
        </div>

        <div wire:key="inbound-yoy-{{ $year ?? 'null' }}">
            <x-chart.card title="Evolución interanual" subtitle="Comparación año seleccionado vs año anterior"
                :chart-id="'inbound-yoy-' . ($year ?? 'null')" type="line" :labels="$yoy['labels'] ?? []" :datasets="[
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
                ]" />
        </div>
    </div>

    {{-- Mapa geográfico --}}
    <div x-data
        x-on:paraguay-map:department-selected.window="
        $wire.selectDepartment($event.detail.department)
    ">
        <x-map.paraguay-departments :map-id="$mapId" :geo-json-url="asset('geo/paraguay-departamentos.json')" :values="$mapByDepartment ?? []" title="Mapa geográfico"
            subtitle="Distribución territorial del turismo receptivo por departamento destino" :height="460" />
            @if ($selectedDepartment)
                <div class="mb-4 rounded-xl border border-blue-200 bg-blue-50 px-4 py-3 text-sm text-blue-800">
                    Departamento seleccionado:
                    <span class="font-semibold">{{ str($selectedDepartment)->replace('-', ' ')->title() }}</span>
                </div>
            @endif
    </div>
</div>
