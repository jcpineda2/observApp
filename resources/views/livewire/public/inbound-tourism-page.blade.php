<div
    class="public-section public-section-spacing"
    x-data
    x-on:paraguay-map:department-selected.window="$wire.selectDepartment($event.detail.department)"
>
    <section class="space-y-6">
        <x-public.ui.section-heading
            eyebrow="Observatorio Turístico"
            title="Turismo receptivo"
            description="Indicadores, aperturas y visualizaciones del turismo receptivo."
        />

        <div class="flex flex-wrap items-center gap-3">
            <x-public.ui.active-period
                :year-label="$this->activeYearLabel"
                :month-label="$this->activeMonthLabel"
            />
        </div>

        <x-public.ui.metric-note
            text="Los indicadores combinan datos observados del período con valores fijos oficiales de referencia para gasto y estadía promedio. El mapa permite explorar el detalle territorial por departamento destino."
        />

        <livewire:public.global-filters />

        <div class="relative space-y-6">


            {{-- KPIs --}}
            <div class="public-kpi-grid">
                <x-public.ui.kpi-card
                    title="Llegadas de turistas"
                    :value="number_format($kpis['tourists'] ?? 0, 0, ',', '.')"
                    badge="Observado"
                    help-text="Total según filtros aplicados."
                />

                <x-public.ui.kpi-card
                    title="Llegadas de excursionistas"
                    :value="number_format($kpis['excursionists'] ?? 0, 0, ',', '.')"
                    badge="Observado"
                    help-text="Visitantes sin pernocte."
                />

                <x-public.ui.kpi-card
                    title="Ingresos de divisas"
                    :value="number_format($kpis['foreign_exchange_revenue'] ?? 0, 2, ',', '.') . ' USD'"
                    badge="Observado"
                    help-text="Suma según registros cargados."
                />

                <x-public.ui.kpi-card
                    title="Gasto promedio"
                    :value="isset($kpis['fixed_average_spend']) && $kpis['fixed_average_spend'] !== null
                        ? number_format($kpis['fixed_average_spend'], 2, ',', '.') . (!empty($kpis['fixed_average_spend_unit']) ? ' ' . $kpis['fixed_average_spend_unit'] : '')
                        : '-'"
                    badge="Dato fijo"
                    :help-text="!empty($kpis['fixed_average_spend_source'])
                        ? 'Valor oficial de referencia. Fuente: ' . $kpis['fixed_average_spend_source']
                        : 'Valor oficial de referencia.'"
                />

                <x-public.ui.kpi-card
                    title="Estadía promedio"
                    :value="isset($kpis['fixed_average_stay']) && $kpis['fixed_average_stay'] !== null
                        ? number_format($kpis['fixed_average_stay'], 2, ',', '.') . (!empty($kpis['fixed_average_stay_unit']) ? ' ' . $kpis['fixed_average_stay_unit'] : '')
                        : '-'"
                    badge="Dato fijo"
                    :help-text="!empty($kpis['fixed_average_stay_source'])
                        ? 'Valor oficial de referencia. Fuente: ' . $kpis['fixed_average_stay_source']
                        : 'Valor oficial de referencia.'"
                />
            </div>

            {{-- Aperturas principales --}}
            <div class="public-two-column-grid">
                <div wire:key="inbound-by-month-{{ $year ?? 'null' }}">
                    @if (count($byMonth['labels'] ?? []))
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
                    @else
                        <x-public.states.no-data
                            title="Sin llegadas por mes"
                            message="No existen registros mensuales para el año seleccionado."
                        />
                    @endif
                </div>

                <div wire:key="inbound-by-country-{{ $year ?? 'null' }}-{{ $month ?? 'all' }}">
                    @if (count($byCountry['labels'] ?? []))
                        <x-chart.card
                            title="Nacionalidad"
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
                    @else
                        <x-public.states.no-data
                            title="Sin países de residencia"
                            message="No existen registros por país para el período seleccionado."
                        />
                    @endif
                </div>
            </div>

            <div class="public-two-column-grid">
                <div wire:key="inbound-by-entry-mode-{{ $year ?? 'null' }}-{{ $month ?? 'all' }}">
                    @if (count($byEntryMode['labels'] ?? []))
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
                    @else
                        <x-public.states.no-data
                            title="Sin vías de ingreso"
                            message="No existen registros por vía de ingreso para el período seleccionado."
                        />
                    @endif
                </div>

                <div wire:key="inbound-by-travel-reason-{{ $year ?? 'null' }}-{{ $month ?? 'all' }}">
                    @if (count($byTravelReason['labels'] ?? []))
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
                    @else
                        <x-public.states.no-data
                            title="Sin motivos de viaje"
                            message="No existen registros por motivo de viaje para el período seleccionado."
                        />
                    @endif
                </div>
            </div>

            {{-- Visualizaciones --}}
            <div class="public-two-column-grid">
                <div wire:key="inbound-top-markets-{{ $year ?? 'null' }}-{{ $month ?? 'all' }}">
                    @if (count($topMarkets['labels'] ?? []))
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
                    @else
                        <x-public.states.no-data
                            title="Sin mercados emisores"
                            message="No existen registros suficientes para construir el ranking del período seleccionado."
                        />
                    @endif
                </div>

                <div wire:key="inbound-yoy-{{ $year ?? 'null' }}">
                    @if (count($yoy['labels'] ?? []))
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
                    @else
                        <x-public.states.no-data
                            title="Sin comparativo interanual"
                            message="No existen datos suficientes para comparar el año seleccionado con el anterior."
                        />
                    @endif
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
                            title="Turistas del departamento"
                            :value="number_format($selectedDepartmentSummary['tourists'] ?? 0, 0, ',', '.')"
                            badge="Mapa"
                            help-text="Llegadas de turistas en el departamento seleccionado."
                        />

                        <x-public.ui.kpi-card
                            title="Excursionistas del departamento"
                            :value="number_format($selectedDepartmentSummary['excursionists'] ?? 0, 0, ',', '.')"
                            badge="Mapa"
                            help-text="Llegadas de excursionistas en el departamento seleccionado."
                        />

                        <x-public.ui.kpi-card
                            title="Divisas del departamento"
                            :value="number_format($selectedDepartmentSummary['foreign_exchange_revenue'] ?? 0, 2, ',', '.') . ' USD'"
                            badge="Mapa"
                            help-text="Ingresos de divisas del departamento seleccionado."
                        />
                    </div>

                    <div wire:key="selected-department-by-country-{{ $selectedDepartment }}-{{ $year ?? 'null' }}-{{ $month ?? 'all' }}">
                        @if (count($selectedDepartmentByCountry['labels'] ?? []))
                            <x-chart.card
                                title="Nacionalidad del departamento seleccionado"
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
                        @else
                            <x-public.states.no-data
                                title="Sin países asociados al departamento"
                                message="No existen registros suficientes para el departamento seleccionado."
                            />
                        @endif
                    </div>
                @else
                    <x-public.states.empty-selection
                        title="Sin departamento seleccionado"
                        message="Selecciona un departamento en el mapa para ver el detalle territorial del turismo receptivo."
                    />
                @endif
            </div>
        </div>
    </section>
</div>
