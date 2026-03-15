<div class="public-section public-section-spacing">
    <section class="space-y-6">
        <x-public.ui.section-heading
            eyebrow="Observatorio Turístico"
            title="Conectividad aérea"
            description="Indicadores, rutas y destinos de la conectividad aérea."
        />

        <div class="flex flex-wrap items-center gap-3">
            <x-public.ui.active-period
                :year-label="$this->activeYearLabel"
                :month-label="$this->activeMonthLabel"
            />
        </div>

        <x-public.ui.metric-note
            text="Los indicadores de conectividad muestran aeropuertos operativos, rutas activas y destinos conectados según los filtros aplicados. Las series mensuales se construyen para el año seleccionado."
        />

        <livewire:public.global-filters />

        <div class="relative space-y-6">


            {{-- KPIs --}}
            <div class="public-kpi-grid">
                <x-public.ui.kpi-card
                    title="Aeropuertos operativos"
                    :value="number_format($kpis['operational_airports'] ?? 0, 0, ',', '.')"
                    badge="Observado"
                    help-text="Cantidad total operativa."
                />

                <x-public.ui.kpi-card
                    title="Aeropuertos nacionales"
                    :value="number_format($kpis['national_airports'] ?? 0, 0, ',', '.')"
                    badge="Observado"
                    help-text="Ámbito nacional."
                />

                <x-public.ui.kpi-card
                    title="Aeropuertos internacionales"
                    :value="number_format($kpis['international_airports'] ?? 0, 0, ',', '.')"
                    badge="Observado"
                    help-text="Ámbito internacional."
                />

                <x-public.ui.kpi-card
                    title="Rutas activas"
                    :value="number_format($kpis['active_routes'] ?? 0, 0, ',', '.')"
                    badge="Observado"
                    help-text="Según filtros aplicados."
                />

                <x-public.ui.kpi-card
                    title="Destinos conectados"
                    :value="number_format($kpis['connected_destinations'] ?? 0, 0, ',', '.')"
                    badge="Observado"
                    help-text="Aeropuertos destino únicos."
                />
            </div>

            <div class="public-two-column-grid">
                <div wire:key="connectivity-flights-seats-by-month-{{ $year ?? 'null' }}">
                    @if (count($flightsSeatsByMonth['labels'] ?? []))
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
                    @else
                        <x-public.states.no-data
                            title="Sin serie mensual disponible"
                            message="No existen registros de vuelos y asientos para el año seleccionado."
                        />
                    @endif
                </div>

                <div wire:key="connectivity-top-airlines-by-seats-{{ $year ?? 'null' }}-{{ $month ?? 'all' }}">
                    @if (count($topAirlinesBySeats['labels'] ?? []))
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
                    @else
                        <x-public.states.no-data
                            title="Sin datos por aerolínea"
                            message="No existen registros de capacidad por aerolínea para el período seleccionado."
                        />
                    @endif
                </div>
            </div>

            <div class="public-two-column-grid">
                <div wire:key="connectivity-top-origin-airports-{{ $year ?? 'null' }}-{{ $month ?? 'all' }}">
                    @if (count($topOriginAirports['labels'] ?? []))
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
                    @else
                        <x-public.states.no-data
                            title="Sin aeropuertos de origen"
                            message="No existen registros de origen para el período seleccionado."
                        />
                    @endif
                </div>

                <div wire:key="connectivity-top-destination-airports-{{ $year ?? 'null' }}-{{ $month ?? 'all' }}">
                    @if (count($topDestinationAirports['labels'] ?? []))
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
                    @else
                        <x-public.states.no-data
                            title="Sin aeropuertos destino"
                            message="No existen registros de destino para el período seleccionado."
                        />
                    @endif
                </div>
            </div>

            <div class="public-two-column-grid">
                <div wire:key="connectivity-destinations-by-country-{{ $year ?? 'null' }}-{{ $month ?? 'all' }}">
                    @if (count($destinationsByCountry['labels'] ?? []))
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
                    @else
                        <x-public.states.no-data
                            title="Sin destinos por país"
                            message="No existen registros por país para el período seleccionado."
                        />
                    @endif
                </div>

                <div wire:key="connectivity-destinations-by-city-{{ $year ?? 'null' }}-{{ $month ?? 'all' }}">
                    @if (count($destinationsByCity['labels'] ?? []))
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
                    @else
                        <x-public.states.no-data
                            title="Sin destinos por ciudad"
                            message="No existen registros por ciudad para el período seleccionado."
                        />
                    @endif
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
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="bg-slate-800 dark:bg-slate-800">
                                <th class="px-4 py-3 text-left font-semibold text-white">
                                    Ruta
                                </th>
                                <th class="px-4 py-3 text-right font-semibold text-white">
                                    Asientos
                                </th>
                                <th class="px-4 py-3 text-right font-semibold text-white">
                                    Vuelos
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-200 bg-white dark:divide-slate-700 dark:bg-slate-900/30">
                            @forelse ($topRoutes as $route)
                                <tr class="bg-white dark:bg-transparent">
                                    <td class="px-4 py-3 text-gray-900 dark:text-slate-100">
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
                                <tr class="bg-white dark:bg-transparent">
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
    </section>
</div>
