<div class="space-y-6">
    <div>
        <h2 class="text-base font-semibold text-gray-900">Empleo turístico</h2>
        <p class="mt-1 text-sm text-gray-500">
            Indicadores, segmentación y composición del empleo turístico.
        </p>
    </div>

    {{-- KPIs --}}
    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <livewire:public-interface.kpi-card
            :key="'employment-direct-'.$year"
            title="Empleo directo"
            :value="number_format($kpis['direct_employment'] ?? 0, 0, ',', '.')"
            badge="Observado"
            helpText="Total de empleo turístico directo"
        />

        <livewire:public-interface.kpi-card
            :key="'employment-national-participation-'.$year"
            title="Participación nacional"
            :value="number_format($kpis['national_participation'] ?? 0, 2, ',', '.')"
            unit="%"
            badge="Observado"
            helpText="Participación del turismo en el empleo nacional"
        />

        <livewire:public-interface.kpi-card
            :key="'employment-yoy-'.$year"
            title="Variación interanual"
            :value="number_format($kpis['interannual_variation'] ?? 0, 2, ',', '.')"
            unit="%"
            badge="Observado"
            helpText="Variación respecto al año anterior"
        />

        <livewire:public-interface.kpi-card
            :key="'employment-segments-'.$year"
            title="Segmentos activos"
            :value="number_format($kpis['active_segments'] ?? 0, 0, ',', '.')"
            badge="Observado"
            helpText="Cantidad de rubros con empleo registrado"
        />
    </div>

    <div class="grid gap-4 lg:grid-cols-2">
        <div wire:key="employment-by-service-sector-{{ $year ?? 'null' }}">
            <x-chart.card
                title="Empleo por segmento"
                subtitle="Distribución del empleo directo por rubro"
                :chart-id="'employment-by-service-sector-'.($year ?? 'null')"
                type="bar"
                :labels="$byServiceSector['labels'] ?? []"
                :datasets="[
                    [
                        'label' => 'Empleo directo',
                        'data' => $byServiceSector['data'] ?? [],
                        'borderWidth' => 1,
                    ]
                ]"
            />
        </div>

        <div wire:key="employment-trend">
            <x-chart.card
                title="Tendencia del empleo"
                subtitle="Serie histórica del empleo directo"
                chart-id="employment-trend"
                type="line"
                :labels="$trend['labels'] ?? []"
                :datasets="[
                    [
                        'label' => 'Empleo directo',
                        'data' => $trend['data'] ?? [],
                        'borderWidth' => 2,
                        'tension' => 0.3,
                    ]
                ]"
            />
        </div>
    </div>

    <div class="grid gap-4 lg:grid-cols-2">
        <div wire:key="employment-yoy-trend">
            <x-chart.card
                title="Variación interanual"
                subtitle="Serie histórica de la variación anual"
                chart-id="employment-yoy-trend"
                type="bar"
                :labels="$yoyTrend['labels'] ?? []"
                :datasets="[
                    [
                        'label' => 'Variación interanual (%)',
                        'data' => $yoyTrend['data'] ?? [],
                        'borderWidth' => 1,
                    ]
                ]"
            />
        </div>

        <div wire:key="employment-by-gender-{{ $year ?? 'null' }}">
            <x-chart.card
                title="Empleo por género"
                subtitle="Distribución por género"
                :chart-id="'employment-by-gender-'.($year ?? 'null')"
                type="doughnut"
                :labels="$byGender['labels'] ?? []"
                :datasets="[
                    [
                        'label' => 'Personas',
                        'data' => $byGender['data'] ?? [],
                    ]
                ]"
            />
        </div>
    </div>

    <div class="grid gap-4 lg:grid-cols-2">
        <div wire:key="employment-by-age-{{ $year ?? 'null' }}">
            <x-chart.card
                title="Empleo por edad"
                subtitle="Distribución por rango etario"
                :chart-id="'employment-by-age-'.($year ?? 'null')"
                type="bar"
                :labels="$byAge['labels'] ?? []"
                :datasets="[
                    [
                        'label' => 'Personas',
                        'data' => $byAge['data'] ?? [],
                        'borderWidth' => 1,
                    ]
                ]"
            />
        </div>

        <div wire:key="employment-gender-by-service-sector-{{ $year ?? 'null' }}">
            <x-chart.card
                title="Género por segmento"
                subtitle="Distribución de género según rubro"
                :chart-id="'employment-gender-by-service-sector-'.($year ?? 'null')"
                type="bar"
                :labels="$genderByServiceSector['labels'] ?? []"
                :datasets="$genderByServiceSector['datasets'] ?? []"
                :height="360"
            />
        </div>
    </div>
</div>
