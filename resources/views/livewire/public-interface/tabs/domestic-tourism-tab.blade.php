<div class="space-y-6">
    <div>
        <h2 class="text-base font-semibold text-gray-900">Turismo interno</h2>
        <p class="mt-1 text-sm text-gray-500">
            Indicadores y aperturas del turismo interno según filtros aplicados.
        </p>
    </div>

    {{-- KPIs --}}
    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        <livewire:public-interface.kpi-card
            :key="'domestic-tourists-'.$year.'-'.$month"
            title="Turistas internos"
            :value="number_format($kpis['tourists'] ?? 0, 0, ',', '.')"
            badge="Observado"
            helpText="Total según filtros aplicados"
        />

        <livewire:public-interface.kpi-card
            :key="'domestic-total-spend-'.$year.'-'.$month"
            title="Gasto total observado"
            :value="number_format($kpis['total_spend_observed'] ?? 0, 2, ',', '.')"
            unit="Gs."
            badge="Observado"
            helpText="Suma del gasto turístico según registros cargados"
        />

        <livewire:public-interface.kpi-card
            :key="'domestic-average-stay-'.$year.'-'.$month"
            title="Estadía promedio observada"
            :value="number_format($kpis['average_stay_observed'] ?? 0, 2, ',', '.')"
            unit="noches"
            badge="Observado"
            helpText="Promedio calculado desde registros cargados"
        />
    </div>

    {{-- Aperturas --}}
    <div class="grid gap-4 lg:grid-cols-2">
        <div wire:key="domestic-by-month-{{ $year ?? 'null' }}">
            <x-chart.card
                title="Turistas por mes"
                subtitle="Apertura mensual del turismo interno"
                :chart-id="'domestic-by-month-'.($year ?? 'null')"
                type="line"
                :labels="$byMonth['labels'] ?? []"
                :datasets="[
                    [
                        'label' => 'Turistas internos',
                        'data' => $byMonth['data'] ?? [],
                        'borderWidth' => 2,
                        'tension' => 0.3,
                    ]
                ]"
            />
        </div>

        <div wire:key="domestic-spend-by-month-{{ $year ?? 'null' }}">
            <x-chart.card
                title="Gasto por mes"
                subtitle="Serie mensual del gasto turístico interno"
                :chart-id="'domestic-spend-by-month-'.($year ?? 'null')"
                type="bar"
                :labels="$spendByMonth['labels'] ?? []"
                :datasets="[
                    [
                        'label' => 'Gasto total',
                        'data' => $spendByMonth['data'] ?? [],
                        'borderWidth' => 1,
                    ]
                ]"
            />
        </div>
    </div>

    <div class="grid gap-4 lg:grid-cols-2">
        <div wire:key="domestic-average-stay-by-month-{{ $year ?? 'null' }}">
            <x-chart.card
                title="Estadía promedio por mes"
                subtitle="Promedio mensual de pernocte"
                :chart-id="'domestic-average-stay-by-month-'.($year ?? 'null')"
                type="line"
                :labels="$avgStayByMonth['labels'] ?? []"
                :datasets="[
                    [
                        'label' => 'Estadía promedio',
                        'data' => $avgStayByMonth['data'] ?? [],
                        'borderWidth' => 2,
                        'tension' => 0.3,
                    ]
                ]"
            />
        </div>

        <div wire:key="domestic-by-destination-department-{{ $year ?? 'null' }}-{{ $month ?? 'all' }}">
            <x-chart.card
                title="Departamento destino"
                subtitle="Top departamentos destino"
                :chart-id="'domestic-by-destination-department-'.($year ?? 'null').'-'.($month ?? 'all')"
                type="bar"
                :labels="$byDestinationDepartment['labels'] ?? []"
                :datasets="[
                    [
                        'label' => 'Turistas internos',
                        'data' => $byDestinationDepartment['data'] ?? [],
                        'borderWidth' => 1,
                    ]
                ]"
            />
        </div>
    </div>

    <div class="grid gap-4 lg:grid-cols-2">
        <div wire:key="domestic-by-origin-region-{{ $year ?? 'null' }}-{{ $month ?? 'all' }}">
            <x-chart.card
                title="Región de origen"
                subtitle="Distribución por región de origen"
                :chart-id="'domestic-by-origin-region-'.($year ?? 'null').'-'.($month ?? 'all')"
                type="doughnut"
                :labels="$byOriginRegion['labels'] ?? []"
                :datasets="[
                    [
                        'label' => 'Turistas internos',
                        'data' => $byOriginRegion['data'] ?? [],
                    ]
                ]"
            />
        </div>

        <div wire:key="domestic-by-travel-reason-{{ $year ?? 'null' }}-{{ $month ?? 'all' }}">
            <x-chart.card
                title="Motivo de viaje"
                subtitle="Distribución por motivo"
                :chart-id="'domestic-by-travel-reason-'.($year ?? 'null').'-'.($month ?? 'all')"
                type="bar"
                :labels="$byTravelReason['labels'] ?? []"
                :datasets="[
                    [
                        'label' => 'Turistas internos',
                        'data' => $byTravelReason['data'] ?? [],
                        'borderWidth' => 1,
                    ]
                ]"
            />
        </div>
    </div>

    <div class="rounded-2xl border border-dashed border-gray-300 bg-gray-50 p-4">
        <h3 class="text-sm font-semibold text-gray-700">Pendiente</h3>
        <p class="mt-1 text-xs text-gray-500">
            Falta incorporar los indicadores fijos del PDF para turismo interno: gasto turístico fijo,
            estadía promedio fija y composición del gasto fija.
        </p>
    </div>
</div>
