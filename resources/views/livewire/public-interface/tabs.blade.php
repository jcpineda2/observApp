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

    <div class="mt-6 rounded-2xl bg-white p-5 shadow-sm ring-1 ring-gray-200">

        @if ($activeTab === 'principal')
            <section id="principal">
                <div class="space-y-4">
                    {{-- <livewire:public-interface.sections.principal-intro /> --}}
                    {{-- <livewire:public-interface.sections.principal-all-kpis /> --}}
                </div>
            </section>
        @endif

        @if ($activeTab === 'turismo-interno')
            <section id="turismo-interno">
                <livewire:public-interface.tabs.domestic-tourism-tab />
            </section>
        @endif

        @if ($activeTab === 'turismo-receptivo')
            <section id="turismo-receptivo">
                <livewire:public-interface.tabs.inbound-tourism-tab />
            </section>
        @endif

        @if ($activeTab === 'prestadores')
            <section id="prestadores">
                <livewire:public-interface.tabs.providers-tab />
            </section>
        @endif

        @if ($activeTab === 'alojamientos')
            <section id="alojamientos">
                <livewire:public-interface.tabs.accommodation-tab />
            </section>
        @endif

        @if ($activeTab === 'empleo')
            <section id="empleo">
                <livewire:public-interface.tabs.employment-tab />
            </section>
        @endif

        @if ($activeTab === 'conectividad')
            <section id="conectividad">
                <livewire:public-interface.tabs.connectivity-tab />
            </section>
        @endif

    </div>
</div>
