<div class="public-section public-section-spacing">
    <section class="space-y-6">
        <x-public.ui.section-heading
            eyebrow="Observatorio Turístico"
            title="Prestadores de servicios turísticos"
            description="Indicadores, evolución y segmentaciones de los prestadores registrados."
        />

        <div class="flex flex-wrap items-center gap-3">
            <x-public.ui.active-period
                :year-label="$this->activeYearLabel"
                :month-label="$this->activeMonthLabel"
            />
        </div>

        <x-public.ui.metric-note
            text="Los indicadores presentan el stock registrado, altas, bajas y formalización del sector según el período seleccionado. Las series mensuales se muestran para el año activo."
        />

        <livewire:public.global-filters />

        <div class="relative space-y-6">

            <div class="public-four-column-grid">
                <x-public.ui.kpi-card
                    title="PST registrados"
                    :value="number_format($kpis['total_registered'] ?? 0, 0, ',', '.')"
                    badge="Observado"
                    help-text="Total nacional según filtros aplicados."
                />

                <x-public.ui.kpi-card
                    title="Altas del período"
                    :value="number_format($kpis['registrations'] ?? 0, 0, ',', '.')"
                    badge="Observado"
                    help-text="Nuevos registros en el período."
                />

                <x-public.ui.kpi-card
                    title="Bajas del período"
                    :value="number_format($kpis['cancellations'] ?? 0, 0, ',', '.')"
                    badge="Observado"
                    help-text="Cancelaciones o bajas en el período."
                />

                <x-public.ui.kpi-card
                    title="% de formalización"
                    :value="number_format($kpis['formalization_rate'] ?? 0, 2, ',', '.') . '%'"
                    badge="Observado"
                    help-text="Formalizados sobre total registrado."
                />
            </div>

            <div class="public-two-column-grid">
                <div wire:key="providers-registrations-cancellations-{{ $year ?? 'null' }}">
                    @if (count($registrationsCancellationsByMonth['labels'] ?? []))
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
                    @else
                        <x-public.states.no-data
                            title="Sin altas y bajas por período"
                            message="No existen registros mensuales de altas y bajas para el año seleccionado."
                        />
                    @endif
                </div>

                <div wire:key="providers-yoy-stock-{{ $year ?? 'null' }}">
                    @if (count($yoyStockByMonth['labels'] ?? []))
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
                    @else
                        <x-public.states.no-data
                            title="Sin comparativo interanual"
                            message="No existen datos suficientes para comparar el año seleccionado con el anterior."
                        />
                    @endif
                </div>
            </div>

            <div class="public-two-column-grid">
                <div wire:key="providers-formalization-by-month-{{ $year ?? 'null' }}">
                    @if (count($formalizationByMonth['labels'] ?? []))
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
                    @else
                        <x-public.states.no-data
                            title="Sin formalización mensual"
                            message="No existen registros de formalización para el año seleccionado."
                        />
                    @endif
                </div>

                <div wire:key="providers-by-service-sector-{{ $year ?? 'null' }}-{{ $month ?? 'all' }}">
                    @if (count($byServiceSector['labels'] ?? []))
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
                    @else
                        <x-public.states.no-data
                            title="Sin segmentación por rubro"
                            message="No existen registros por rubro para el período seleccionado."
                        />
                    @endif
                </div>
            </div>

            <div wire:key="providers-by-department-{{ $year ?? 'null' }}-{{ $month ?? 'all' }}">
                @if (count($byDepartment['labels'] ?? []))
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
                @else
                    <x-public.states.no-data
                        title="Sin distribución territorial"
                        message="No existen registros por departamento para el período seleccionado."
                    />
                @endif
            </div>
        </div>
    </section>
</div>
