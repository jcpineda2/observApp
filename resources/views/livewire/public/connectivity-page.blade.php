<div class="public-section public-section-spacing">
    <div class="public-section-header">
        <h2 class="public-section-title">Conectividad aérea</h2>
        <p class="public-section-description">
            Indicadores, rutas y destinos de la conectividad aérea.
        </p>
    </div>

    {{-- KPIs --}}
    <div class="public-kpi-grid">
        <livewire:public-interface.kpi-card
            :key="'connectivity-operational-airports-' . $year . '-' . $month"
            title="Aeropuertos operativos"
            :value="number_format($kpis['operational_airports'] ?? 0, 0, ',', '.')"
            badge="Observado"
            helpText="Cantidad total operativa"
        />

        <livewire:public-interface.kpi-card
            :key="'connectivity-national-airports-' . $year . '-' . $month"
            title="Aeropuertos nacionales"
            :value="number_format($kpis['national_airports'] ?? 0, 0, ',', '.')"
            badge="Observado"
            helpText="Ámbito nacional"
        />

        <livewire:public-interface.kpi-card
            :key="'connectivity-international-airports-' . $year . '-' . $month"
            title="Aeropuertos internacionales"
            :value="number_format($kpis['international_airports'] ?? 0, 0, ',', '.')"
            badge="Observado"
            helpText="Ámbito internacional"
        />

        <livewire:public-interface.kpi-card
            :key="'connectivity-active-routes-' . $year . '-' . $month"
            title="Rutas activas"
            :value="number_format($kpis['active_routes'] ?? 0, 0, ',', '.')"
            badge="Observado"
            helpText="Según filtros aplicados"
        />

        <livewire:public-interface.kpi-card
            :key="'connectivity-destinations-' . $year . '-' . $month"
            title="Destinos conectados"
            :value="number_format($kpis['connected_destinations'] ?? 0, 0, ',', '.')"
            badge="Observado"
            helpText="Aeropuertos destino únicos"
        />
    </div>

    <div class="public-two-column-grid">
        <div wire:key="connectivity-flights-seats-by-month-{{ $year ?? 'null' }}">
            <x-chart.card
                title="Vuelos y asientos por mes"
                subtitle="Serie mensual de conectividad aérea"
                :chart-id="'connectivity-flights-seats-by-month-' . ($year ?? 'null')"
                type="line"
                bodyClass="public-chart-standard"
                :labels="$flightsSeatsByMonth['labels'] ?? []"
                :datasets="[
                    [
                        'label' => 'Vuelos',
                        'data' => $flightsSeatsByMonth['flights'] ?? [],
                        'borderWidth' => 2,
                        'tension' => 0.3,
                    ],
                    [
                        'label' => 'Asientos',
                        'data' => $flightsSeatsByMonth['seats'] ?? [],
                        'borderWidth' => 2,
                        'tension' => 0.3,
                    ],
                ]"
            />
        </div>

        <div wire:key="connectivity-top-airlines-by-seats-{{ $year ?? 'null' }}-{{ $month ?? 'all' }}">
            <x-chart.card
                title="Top aerolíneas por asientos"
                subtitle="Capacidad ofertada por aerolínea"
                :chart-id="'connectivity-top-airlines-by-seats-' . ($year ?? 'null') . '-' . ($month ?? 'all')"
                type="bar"
                bodyClass="public-chart-standard"
                :labels="$topAirlinesBySeats['labels'] ?? []"
                :datasets="[
                    [
                        'label' => 'Asientos',
                        'data' => $topAirlinesBySeats['data'] ?? [],
                        'borderWidth' => 1,
                    ],
                ]"
            />
        </div>
    </div>

    <div class="public-two-column-grid">
        <div wire:key="connectivity-top-origin-airports-{{ $year ?? 'null' }}-{{ $month ?? 'all' }}">
            <x-chart.card
                title="Top aeropuertos origen"
                subtitle="Aeropuertos de salida con mayor capacidad"
                :chart-id="'connectivity-top-origin-airports-' . ($year ?? 'null') . '-' . ($month ?? 'all')"
                type="bar"
                bodyClass="public-chart-standard"
                :labels="$topOriginAirports['labels'] ?? []"
                :datasets="[
                    [
                        'label' => 'Asientos',
                        'data' => $topOriginAirports['data'] ?? [],
                        'borderWidth' => 1,
                    ],
                ]"
            />
        </div>

        <div wire:key="connectivity-top-destination-airports-{{ $year ?? 'null' }}-{{ $month ?? 'all' }}">
            <x-chart.card
                title="Top aeropuertos destino"
                subtitle="Aeropuertos de llegada con mayor capacidad"
                :chart-id="'connectivity-top-destination-airports-' . ($year ?? 'null') . '-' . ($month ?? 'all')"
                type="bar"
                bodyClass="public-chart-standard"
                :labels="$topDestinationAirports['labels'] ?? []"
                :datasets="[
                    [
                        'label' => 'Asientos',
                        'data' => $topDestinationAirports['data'] ?? [],
                        'borderWidth' => 1,
                    ],
                ]"
            />
        </div>
    </div>

    <div class="public-two-column-grid">
        <div wire:key="connectivity-destinations-by-country-{{ $year ?? 'null' }}-{{ $month ?? 'all' }}">
            <x-chart.card
                title="Destinos por país"
                subtitle="Segmentación por país de destino"
                :chart-id="'connectivity-destinations-by-country-' . ($year ?? 'null') . '-' . ($month ?? 'all')"
                type="doughnut"
                bodyClass="public-chart-standard"
                :labels="$destinationsByCountry['labels'] ?? []"
                :datasets="[
                    [
                        'label' => 'Destinos',
                        'data' => $destinationsByCountry['data'] ?? [],
                    ],
                ]"
            />
        </div>

        <div wire:key="connectivity-destinations-by-city-{{ $year ?? 'null' }}-{{ $month ?? 'all' }}">
            <x-chart.card
                title="Destinos por ciudad"
                subtitle="Top ciudades conectadas"
                :chart-id="'connectivity-destinations-by-city-' . ($year ?? 'null') . '-' . ($month ?? 'all')"
                type="bar"
                bodyClass="public-chart-standard"
                :labels="$destinationsByCity['labels'] ?? []"
                :datasets="[
                    [
                        'label' => 'Destinos',
                        'data' => $destinationsByCity['data'] ?? [],
                        'borderWidth' => 1,
                    ],
                ]"
            />
        </div>
    </div>

    <div class="ui-surface p-5 sm:p-6">
        <div class="space-y-1">
            <h3 class="ui-heading text-base">Top rutas</h3>
            <p class="ui-text-muted text-sm">
                Rutas con mayor capacidad ofertada según filtros aplicados.
            </p>
        </div>

        <div class="mt-5 overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm dark:divide-slate-700">
                <thead class="bg-gray-50 dark:bg-slate-800/70">
                    <tr>
                        <th class="px-4 py-3 text-left font-medium text-gray-600 dark:text-slate-300">
                            Ruta
                        </th>
                        <th class="px-4 py-3 text-right font-medium text-gray-600 dark:text-slate-300">
                            Asientos
                        </th>
                        <th class="px-4 py-3 text-right font-medium text-gray-600 dark:text-slate-300">
                            Vuelos
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100 bg-white dark:divide-slate-700 dark:bg-transparent">
                    @forelse ($topRoutes as $route)
                        <tr class="hover:bg-gray-50 dark:hover:bg-slate-800/40">
                            <td class="px-4 py-3 text-gray-800 dark:text-slate-100">
                                {{ $route['route'] }}
                            </td>
                            <td class="px-4 py-3 text-right text-gray-700 dark:text-slate-300">
                                {{ number_format($route['seats'], 0, ',', '.') }}
                            </td>
                            <td class="px-4 py-3 text-right text-gray-700 dark:text-slate-300">
                                {{ number_format($route['flights'], 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-4 py-4 text-center text-gray-500 dark:text-slate-400">
                                Sin datos para los filtros seleccionados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
