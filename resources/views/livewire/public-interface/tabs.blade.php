<div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
    {{-- Barra de Tabs (Desktop) --}}
    <div class="hidden md:block">
        <div class="flex items-center justify-between gap-4">
            <h1 class="text-xl font-semibold text-gray-900">
                Observatorio Turístico
            </h1>

            <div class="flex flex-wrap items-center gap-2">
                @foreach ($tabs as $key => $label)
                    <button type="button" wire:click="setTab('{{ $key }}')" @class([
                        'rounded-full px-4 py-2 text-sm font-medium transition',
                        'bg-blue-800 text-white' => $activeTab === $key,
                        'bg-white text-gray-700 ring-1 ring-gray-200 hover:bg-gray-50' =>
                            $activeTab !== $key,
                    ])>
                        {{ $label }}
                    </button>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Selector (Mobile) --}}
    <div class="md:hidden">
        <div class="flex items-center justify-between gap-3">
            <h1 class="text-lg font-semibold text-gray-900">
                Observatorio
            </h1>

            <div class="w-60">
                <label class="sr-only">Sección</label>
                <select
                    class="w-full rounded-lg border-gray-200 bg-white px-3 py-2 text-sm shadow-sm focus:border-blue-600 focus:ring-blue-600"
                    wire:change="setTab($event.target.value)">
                    @foreach ($tabs as $key => $label)
                        <option value="{{ $key }}" @selected($activeTab === $key)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="pt-9">
        <livewire:public-interface.global-filters />
    </div>
    {{-- Contenedor de contenido --}}
    <div class="mt-6 rounded-2xl bg-white p-5 shadow-sm ring-1 ring-gray-200">

        {{-- PRINCIPAL --}}
        <section id="principal" @class([$activeTab !== 'principal' ? 'hidden' : ''])>
            <div class="space-y-4">
                <livewire:public-interface.sections.principal-all-kpis />
            </div>
        </section>
        {{-- TURISMO INTERNO --}}
        <section id="turismo-interno" @class([$activeTab !== 'turismo-interno' ? 'hidden' : ''])>
            <div class="space-y-4">
                <livewire:public-interface.kpis.domestic-tourism-kpis />
                <div class="mt-4 grid gap-4 lg:grid-cols-2">
                    <livewire:public-interface.charts.domestic-tourism-by-month />
                    <livewire:public-interface.charts.domestic-spend-by-month />
                </div>

                <div class="mt-4 grid gap-4 lg:grid-cols-2">
                    <livewire:public-interface.charts.domestic-average-stay-by-month />
                    <livewire:public-interface.charts.domestic-by-destination-department />
                </div>

                <div class="mt-4 grid gap-4 lg:grid-cols-2">
                    <livewire:public-interface.charts.domestic-by-origin-region />
                    <livewire:public-interface.charts.domestic-by-travel-reason />
                </div>
            </div>
        </section>
        {{-- TURISMO RECEPTIVO --}}
        <section id="turismo-receptivo" @class([$activeTab !== 'turismo-receptivo' ? 'hidden' : ''])>
            <div class="space-y-4">
                <h2 class="text-base font-semibold text-gray-900">Turismo receptivo</h2>
                <livewire:public-interface.kpis.inbound-tourism-kpis />

                <div class="grid gap-4 lg:grid-cols-2">
                </div>
                <div class="mt-4">
                    <livewire:public-interface.charts.inbound-tourism-by-month />
                    <livewire:public-interface.charts.inbound-top-countries />
                    <livewire:public-interface.charts.inbound-by-travel-reason />
                </div>
            </div>
        </section>
    {{-- PRESTADORES --}}
    <section id="prestadores" @class([$activeTab !== 'prestadores' ? 'hidden' : ''])>
        <div class="space-y-4">
            <h2 class="text-base font-semibold text-gray-900">Prestadores de servicios turísticos</h2>
            <livewire:public-interface.kpis.tourism-providers-kpis />
            <div class="mt-4 grid gap-4 lg:grid-cols-2">
                <livewire:public-interface.charts.providers-registrations-cancellations-by-month />
                <livewire:public-interface.charts.providers-yo-y-stock-by-month />
            </div>
            <div class="mt-4">
                <livewire:public-interface.charts.providers-formalization-by-month />
                <livewire:public-interface.charts.providers-by-service-sector />
            </div>

            <div class="mt-4">
                <livewire:public-interface.maps.providers-by-department-map />
            </div>
        </div>
    </section>

    {{-- ALOJAMIENTOS --}}
    <section id="alojamientos" @class([$activeTab !== 'alojamientos' ? 'hidden' : ''])>
        <div class="space-y-4">
            <h2 class="text-base font-semibold text-gray-900">Alojamientos turísticos</h2>
            <livewire:public-interface.kpis.accommodation-kpis />
            <livewire:public-interface.kpis.accommodation-capacity-kpis />
            <div class="mt-4 grid gap-4 lg:grid-cols-2">
                <livewire:public-interface.charts.accommodation-installed-capacity-by-month />
                <livewire:public-interface.charts.accommodation-occupancy-by-month />
                <livewire:public-interface.charts.accommodation-by-category />
            </div>

            <div class="mt-4 grid gap-4 lg:grid-cols-2">
                <livewire:public-interface.charts.accommodation-occupancy-yo-y-by-month />
                <livewire:public-interface.charts.accommodation-season-vs-occupancy />
            </div>

            <div class="mt-4 grid gap-4 lg:grid-cols-2">
                <livewire:public-interface.charts.accommodation-installed-capacity-by-month />
                <livewire:public-interface.charts.accommodation-available-rooms-by-month />
            </div>
            <div class="h-64 rounded-xl bg-gray-50 ring-1 ring-gray-200"></div>
        </div>
    </section>

    {{-- EMPLEO --}}
    <section id="empleo" @class([$activeTab !== 'empleo' ? 'hidden' : ''])>
        <div class="space-y-4">
            <h2 class="text-base font-semibold text-gray-900">Empleo turístico</h2>
            <livewire:public-interface.kpis.tourism-employment-kpis />

            <div class="mt-4 grid gap-4 lg:grid-cols-2">
                <livewire:public-interface.charts.employment-by-service-sector />
                <livewire:public-interface.charts.employment-trend />
            </div>
            <div class="mt-4 grid gap-4 lg:grid-cols-2">
                <livewire:public-interface.charts.employment-yo-y-trend />
                <livewire:public-interface.charts.employment-by-gender />
            </div>
            <div class="mt-4 grid gap-4 lg:grid-cols-2">
                <livewire:public-interface.charts.employment-by-age />
                <livewire:public-interface.charts.employment-gender-by-service-sector />
            </div>

        </div>
    </section>

    {{-- CONECTIVIDAD --}}
    <section id="conectividad" @class([$activeTab !== 'conectividad' ? 'hidden' : ''])>
        <div class="space-y-4">
            <livewire:public-interface.kpis.air-connectivity-kpis />

            <div class="mt-4 grid gap-4 lg:grid-cols-2">
                <livewire:public-interface.charts.air-connectivity-flights-seats-by-month />
                <livewire:public-interface.charts.top-airlines-by-seats />
            </div>
            <div class="mt-4">
                <livewire:public-interface.tables.top-air-routes />

                {{-- Toggle arriba para controlar todos los TOP --}}
                <livewire:public-interface.controls.air-metric-toggle />

                <div class="mt-4 grid gap-4 lg:grid-cols-2">
                    <livewire:public-interface.charts.top-airports-by-metric role="origin" />
                    <livewire:public-interface.charts.top-airports-by-metric role="destination" />
                </div>
                <div class="h-64 rounded-xl bg-gray-50 ring-1 ring-gray-200"></div>
            </div>
    </section>

</div>
