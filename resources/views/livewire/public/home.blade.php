<section class="space-y-6">
    <header class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
        <h1 class="text-2xl sm:text-3xl font-semibold">Observatorio Turístico</h1>
        <p class="mt-2 text-slate-600">
            Indicadores y tableros con datos oficiales.
        </p>

        <div class="mt-5 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <a href="{{ route('public.providers') }}"
               class="group bg-background-light border border-slate-100 rounded-2xl p-4 hover:shadow-sm transition">
                <div class="flex items-center justify-between">
                    <div class="text-sm font-semibold">Prestadores</div>
                    <span class="material-symbols-outlined text-primary">apartment</span>
                </div>
                <div class="mt-2 text-xs text-slate-500">
                    Total, altas/bajas, formalización, variación.
                </div>
            </a>

            <a href="{{ route('public.inbound') }}"
               class="group bg-background-light border border-slate-100 rounded-2xl p-4 hover:shadow-sm transition">
                <div class="flex items-center justify-between">
                    <div class="text-sm font-semibold">Turismo Receptivo</div>
                    <span class="material-symbols-outlined text-primary">flight_land</span>
                </div>
                <div class="mt-2 text-xs text-slate-500">
                    Indicadores de entrada y comportamiento.
                </div>
            </a>

            <a href="{{ route('public.domestic') }}"
               class="group bg-background-light border border-slate-100 rounded-2xl p-4 hover:shadow-sm transition">
                <div class="flex items-center justify-between">
                    <div class="text-sm font-semibold">Turismo Interno</div>
                    <span class="material-symbols-outlined text-primary">tour</span>
                </div>
                <div class="mt-2 text-xs text-slate-500">
                    Motivos, flujo, gasto, estadía.
                </div>
            </a>
        </div>
    </header>

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
        <div class="text-sm font-semibold">Cómo usar</div>
        <ul class="mt-3 text-sm text-slate-600 list-disc pl-5 space-y-1">
            <li>Entrá a un tablero en “Indicadores”.</li>
            <li>Filtrá por año/mes/rubro/departamento.</li>
            <li>Los KPIs y gráficos se actualizan sin recargar (Livewire 3).</li>
        </ul>
    </div>
</section>
