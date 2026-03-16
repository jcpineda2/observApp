<div class="public-section public-section-spacing">
    <section class="space-y-6">
        <x-public.ui.section-heading
            eyebrow="Observatorio Turístico"
            title="Empleo turístico"
            description="Indicadores, segmentación y composición del empleo turístico."
        />

        <div class="flex flex-wrap items-center gap-3">
            <x-public.ui.active-period
                :year-label="$this->activeYearLabel"
                :month-label="$this->activeMonthLabel"
            />
        </div>

        <x-public.ui.metric-note
            text="Los indicadores de empleo muestran valores observados para el año seleccionado. Las tendencias históricas se presentan de forma anual para facilitar la comparación en el tiempo."
        />

        <livewire:public.global-filters />

        <div class="relative space-y-6">


            {{-- KPIs --}}
            <div class="public-four-column-grid">
                <x-public.ui.kpi-card
                    title="Empleo directo"
                    :value="number_format($kpis['direct_employment'] ?? 0, 0, ',', '.')"
                    badge="Observado"
                    help-text="Total de empleo turístico directo."
                />

                <x-public.ui.kpi-card
                    title="Participación nacional"
                    :value="number_format($kpis['national_participation'] ?? 0, 2, ',', '.') . '%'"
                    badge="Observado"
                    help-text="Participación del turismo en el empleo nacional."
                />

                <x-public.ui.kpi-card
                    title="Variación interanual"
                    :value="number_format($kpis['interannual_variation'] ?? 0, 2, ',', '.') . '%'"
                    badge="Observado"
                    help-text="Variación respecto al año anterior."
                />

                <x-public.ui.kpi-card
                    title="Segmentos activos"
                    :value="number_format($kpis['active_segments'] ?? 0, 0, ',', '.')"
                    badge="Observado"
                    help-text="Cantidad de rubros con empleo registrado."
                />
            </div>

            <div class="public-two-column-grid">
                <div wire:key="employment-by-service-sector-{{ $year ?? 'null' }}">
                    @if (count($byServiceSector['labels'] ?? []))
                        <x-chart.card
                            title="Empleo por segmento"
                            subtitle="Distribución del empleo directo por rubro"
                            :chart-id="'employment-by-service-sector-' . ($year ?? 'null')"
                            type="bar"
                            bodyClass="public-chart-standard"
                            :labels="$byServiceSector['labels'] ?? []"
                            :datasets="[
                                [
                                    'label' => 'Empleo directo',
                                    'data' => $byServiceSector['data'] ?? [],
                                    'borderWidth' => 1,
                                ],
                            ]"
                        />
                    @else
                        <x-public.states.no-data
                            title="Sin empleo por segmento"
                            message="No existen registros por segmento para el año seleccionado."
                        />
                    @endif
                </div>

                <div wire:key="employment-trend">
                    @if (count($trend['labels'] ?? []))
                        <x-chart.card
                            title="Tendencia del empleo"
                            subtitle="Serie histórica del empleo directo"
                            chart-id="employment-trend"
                            type="line"
                            bodyClass="public-chart-standard"
                            :labels="$trend['labels'] ?? []"
                            :datasets="[
                                [
                                    'label' => 'Empleo directo',
                                    'data' => $trend['data'] ?? [],
                                    'borderWidth' => 2,
                                    'tension' => 0.3,
                                ],
                            ]"
                        />
                    @else
                        <x-public.states.no-data
                            title="Sin tendencia histórica"
                            message="No existen datos históricos de empleo para mostrar la tendencia."
                        />
                    @endif
                </div>
            </div>

            <div class="public-two-column-grid">
                <div wire:key="employment-yoy-trend">
                    @if (count($yoyTrend['labels'] ?? []))
                        <x-chart.card
                            title="Variación interanual"
                            subtitle="Serie histórica de la variación anual"
                            chart-id="employment-yoy-trend"
                            type="bar"
                            bodyClass="public-chart-standard"
                            :labels="$yoyTrend['labels'] ?? []"
                            :datasets="[
                                [
                                    'label' => 'Variación interanual (%)',
                                    'data' => $yoyTrend['data'] ?? [],
                                    'borderWidth' => 1,
                                ],
                            ]"
                        />
                    @else
                        <x-public.states.no-data
                            title="Sin variación histórica"
                            message="No existen datos históricos suficientes para mostrar la variación interanual."
                        />
                    @endif
                </div>

                <div wire:key="employment-by-gender-{{ $year ?? 'null' }}">
                    @if (count($byGender['labels'] ?? []))
                        <x-chart.card
                            title="Empleo por género"
                            subtitle="Distribución por género"
                            :chart-id="'employment-by-gender-' . ($year ?? 'null')"
                            type="doughnut"
                            bodyClass="public-chart-standard"
                            :labels="$byGender['labels'] ?? []"
                            :datasets="[
                                [
                                    'label' => 'Personas',
                                    'data' => $byGender['data'] ?? [],
                                ],
                            ]"
                        />
                    @else
                        <x-public.states.no-data
                            title="Sin distribución por género"
                            message="No existen registros por género para el año seleccionado."
                        />
                    @endif
                </div>
            </div>

            <div class="public-two-column-grid">
                <div wire:key="employment-by-age-{{ $year ?? 'null' }}">
                    @if (count($byAge['labels'] ?? []))
                        <x-chart.card
                            title="Empleo por edad"
                            subtitle="Distribución por rango etario"
                            :chart-id="'employment-by-age-' . ($year ?? 'null')"
                            type="bar"
                            bodyClass="public-chart-standard"
                            :labels="$byAge['labels'] ?? []"
                            :datasets="[
                                [
                                    'label' => 'Personas',
                                    'data' => $byAge['data'] ?? [],
                                    'borderWidth' => 1,
                                ],
                            ]"
                        />
                    @else
                        <x-public.states.no-data
                            title="Sin distribución por edad"
                            message="No existen registros por rango etario para el año seleccionado."
                        />
                    @endif
                </div>

                <div wire:key="employment-gender-by-service-sector-{{ $year ?? 'null' }}">
                    @if (count($genderByServiceSector['labels'] ?? []))
                        <x-chart.card
                            title="Género por segmento"
                            subtitle="Distribución de género según rubro"
                            :chart-id="'employment-gender-by-service-sector-' . ($year ?? 'null')"
                            type="bar"
                            bodyClass="public-chart-tall"
                            :labels="$genderByServiceSector['labels'] ?? []"
                            :datasets="$genderByServiceSector['datasets'] ?? []"
                            :height="360"
                        />
                    @else
                        <x-public.states.no-data
                            title="Sin distribución de género por segmento"
                            message="No existen registros suficientes para mostrar la distribución por rubro."
                        />
                    @endif
                </div>
            </div>
        </div>
    </section>
</div>
