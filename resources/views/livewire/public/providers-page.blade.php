<div class="public-section public-section-spacing">
    <div class="public-section-header">
        <h2 class="public-section-title">Prestadores de servicios turísticos</h2>
        <p class="public-section-description">
            Indicadores, evolución y segmentaciones de los prestadores registrados.
        </p>
    </div>

    <div class="public-four-column-grid">
        <livewire:public-interface.kpi-card
            :key="'providers-total-' . $year . '-' . $month"
            title="PST registrados"
            :value="number_format($kpis['total_registered'] ?? 0, 0, ',', '.')"
            badge="Observado"
            helpText="Total nacional según filtros aplicados"
        />

        <livewire:public-interface.kpi-card
            :key="'providers-registrations-' . $year . '-' . $month"
            title="Altas del período"
            :value="number_format($kpis['registrations'] ?? 0, 0, ',', '.')"
            badge="Observado"
            helpText="Nuevos registros en el período"
        />

        <livewire:public-interface.kpi-card
            :key="'providers-cancellations-' . $year . '-' . $month"
            title="Bajas del período"
            :value="number_format($kpis['cancellations'] ?? 0, 0, ',', '.')"
            badge="Observado"
            helpText="Cancelaciones o bajas en el período"
        />

        <livewire:public-interface.kpi-card
            :key="'providers-formalization-rate-' . $year . '-' . $month"
            title="% de formalización"
            :value="number_format($kpis['formalization_rate'] ?? 0, 2, ',', '.')"
            unit="%"
            badge="Observado"
            helpText="Formalizados sobre total registrado"
        />
    </div>

    <div class="public-two-column-grid">
        <div wire:key="providers-registrations-cancellations-{{ $year ?? 'null' }}">
            <x-chart.card
                title="Altas y bajas por período"
                subtitle="Serie mensual de registros y cancelaciones"
                :chart-id="'providers-registrations-cancellations-' . ($year ?? 'null')"
                type="line"
                bodyClass="public-chart-standard"
                :labels="$registrationsCancellationsByMonth['labels'] ?? []"
                :datasets="[
                    [
                        'label' => 'Altas',
                        'data' => $registrationsCancellationsByMonth['registrations'] ?? [],
                        'borderWidth' => 2,
                        'tension' => 0.3,
                    ],
                    [
                        'label' => 'Bajas',
                        'data' => $registrationsCancellationsByMonth['cancellations'] ?? [],
                        'borderWidth' => 2,
                        'tension' => 0.3,
                    ],
                ]"
            />
        </div>

        <div wire:key="providers-yoy-stock-{{ $year ?? 'null' }}">
            <x-chart.card
                title="Variación interanual"
                subtitle="Comparación del stock total por mes"
                :chart-id="'providers-yoy-stock-' . ($year ?? 'null')"
                type="line"
                bodyClass="public-chart-standard"
                :labels="$yoyStockByMonth['labels'] ?? []"
                :datasets="[
                    [
                        'label' => 'Año actual ' . ($yoyStockByMonth['current_year'] ?? ''),
                        'data' => $yoyStockByMonth['current'] ?? [],
                        'borderWidth' => 2,
                        'tension' => 0.3,
                    ],
                    [
                        'label' => 'Año anterior ' . ($yoyStockByMonth['previous_year'] ?? ''),
                        'data' => $yoyStockByMonth['previous'] ?? [],
                        'borderWidth' => 2,
                        'borderDash' => [5, 5],
                        'tension' => 0.3,
                    ],
                ]"
            />
        </div>
    </div>

    <div class="public-two-column-grid">
        <div wire:key="providers-formalization-by-month-{{ $year ?? 'null' }}">
            <x-chart.card
                title="Porcentaje de formalización"
                subtitle="Serie mensual de formalización del sector"
                :chart-id="'providers-formalization-by-month-' . ($year ?? 'null')"
                type="bar"
                bodyClass="public-chart-standard"
                :labels="$formalizationByMonth['labels'] ?? []"
                :datasets="[
                    [
                        'label' => 'Formalización (%)',
                        'data' => $formalizationByMonth['data'] ?? [],
                        'borderWidth' => 1,
                    ],
                ]"
            />
        </div>

        <div wire:key="providers-by-service-sector-{{ $year ?? 'null' }}-{{ $month ?? 'all' }}">
            <x-chart.card
                title="Segmentación por rubro"
                subtitle="Distribución de prestadores por tipo de actividad"
                :chart-id="'providers-by-service-sector-' . ($year ?? 'null') . '-' . ($month ?? 'all')"
                type="bar"
                bodyClass="public-chart-standard"
                :labels="$byServiceSector['labels'] ?? []"
                :datasets="[
                    [
                        'label' => 'PST registrados',
                        'data' => $byServiceSector['data'] ?? [],
                        'borderWidth' => 1,
                    ],
                ]"
            />
        </div>
    </div>

    <div wire:key="providers-by-department-{{ $year ?? 'null' }}-{{ $month ?? 'all' }}">
        <x-chart.card
            title="Distribución territorial"
            subtitle="Prestadores registrados por departamento"
            :chart-id="'providers-by-department-' . ($year ?? 'null') . '-' . ($month ?? 'all')"
            type="bar"
            bodyClass="public-chart-tall"
            :labels="$byDepartment['labels'] ?? []"
            :datasets="[
                [
                    'label' => 'PST registrados',
                    'data' => $byDepartment['data'] ?? [],
                    'borderWidth' => 1,
                ],
            ]"
            :height="360"
        />
    </div>
</div>
