<div>
<section class="relative px-5 pt-8 pb-6">
    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-primary/10 to-brand-blue/10 rounded-full blur-2xl -z-10"></div>

    <div class="flex flex-col gap-1 mb-6">
        <span class="text-xs font-semibold tracking-wider text-primary uppercase">Datos Oficiales</span>
        <h2 class="text-3xl font-bold text-slate-900 leading-tight">Bienvenidos al Observatorio</h2>
        <p class="text-slate-500 text-sm mt-1">
            Información estadística actualizada del turismo en Paraguay.
        </p>
    </div>

    <div class="w-full h-40 bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden relative group">
        <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1576487241809-4181f4d9b62d?q=80&w=1200&auto=format&fit=crop')] bg-cover bg-center opacity-20 group-hover:scale-105 transition-transform duration-700"></div>
        <div class="absolute inset-0 flex items-center justify-center">
            <div class="text-center">
                <span class="material-symbols-outlined text-4xl text-primary/80 mb-2">map</span>
                <p class="text-xs font-medium text-slate-600">Explorar Mapa Interactivo</p>
            </div>
        </div>
    </div>

    <div class="mt-4 grid grid-cols-2 gap-3">
        <div class="bg-white rounded-xl border border-slate-100 p-3">
            <p class="text-[10px] uppercase tracking-wider text-slate-500 font-semibold">Turismo Receptivo (año actual)</p>
            <p class="text-xl font-bold text-slate-900 mt-1">{{ number_format($stats['inbound_arrivals']) }}</p>
        </div>
        <div class="bg-white rounded-xl border border-slate-100 p-3">
            <p class="text-[10px] uppercase tracking-wider text-slate-500 font-semibold">Turismo Interno (año actual)</p>
            <p class="text-xl font-bold text-slate-900 mt-1">{{ number_format($stats['domestic_tourists']) }}</p>
        </div>
    </div>
</section>

<section class="px-4 pb-6">
    <h3 class="text-lg font-bold text-slate-900 mb-4 px-1">Indicadores Principales</h3>

    <div class="grid grid-cols-1 gap-4">

        {{-- Turismo Interno --}}
        <article class="bg-white rounded-xl p-5 shadow-sm border border-slate-100 flex flex-col gap-4">
            <div class="flex items-start justify-between">
                <div class="w-10 h-10 rounded-lg bg-orange-50 flex items-center justify-center text-orange-600">
                    <span class="material-symbols-outlined">tour</span>
                </div>
            </div>

            <div>
                <h4 class="text-lg font-bold text-slate-900">Turismo Interno</h4>
                <p class="text-sm text-slate-500 mt-1">Movimiento turístico nacional y destinos preferidos.</p>
            </div>

            <div class="pt-2 mt-auto">
                <a href="{{ route('public.domestic') }}"
                   class="w-full h-10 bg-primary hover:bg-primary-dark text-white rounded-lg font-semibold text-sm transition-colors flex items-center justify-center gap-2">
                    <span>Ver el Tablero</span>
                    <span class="material-symbols-outlined text-sm">arrow_forward</span>
                </a>
            </div>
        </article>

        {{-- Turismo Receptivo --}}
        <article class="bg-white rounded-xl p-5 shadow-sm border border-slate-100 flex flex-col gap-4">
            <div class="flex items-start justify-between">
                <div class="w-10 h-10 rounded-lg bg-purple-50 flex items-center justify-center text-purple-600">
                    <span class="material-symbols-outlined">flight_land</span>
                </div>
            </div>

            <div>
                <h4 class="text-lg font-bold text-slate-900">Turismo Receptivo</h4>
                <p class="text-sm text-slate-500 mt-1">Visitantes internacionales y flujo de entrada por fronteras.</p>
            </div>

            <div class="pt-2 mt-auto">
                <a href="{{ route('public.inbound') }}"
                   class="w-full h-10 bg-primary hover:bg-primary-dark text-white rounded-lg font-semibold text-sm transition-colors flex items-center justify-center gap-2">
                    <span>Ver el Tablero</span>
                    <span class="material-symbols-outlined text-sm">arrow_forward</span>
                </a>
            </div>
        </article>

        {{-- Los otros “cards” los dejamos como “próximamente” --}}
        <article class="bg-white rounded-xl p-5 shadow-sm border border-slate-100 flex flex-col gap-4 opacity-80">
            <div class="flex items-start justify-between">
                <div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center text-brand-blue">
                    <span class="material-symbols-outlined">directions_boat</span>
                </div>
                <span class="bg-slate-100 text-slate-700 text-[10px] font-bold px-2 py-1 rounded-full uppercase tracking-wide">Próximamente</span>
            </div>
            <div>
                <h4 class="text-lg font-bold text-slate-900">Cruceros</h4>
                <p class="text-sm text-slate-500 mt-1">Estadísticas de llegada de cruceros y embarcaciones turísticas.</p>
            </div>
            <div class="pt-2 mt-auto">
                <button disabled class="w-full h-10 bg-slate-200 text-slate-500 rounded-lg font-semibold text-sm">
                    Ver el Tablero
                </button>
            </div>
        </article>

        <article class="bg-white rounded-xl p-5 shadow-sm border border-slate-100 flex flex-col gap-4 opacity-80">
            <div class="flex items-start justify-between">
                <div class="w-10 h-10 rounded-lg bg-teal-50 flex items-center justify-center text-teal-600">
                    <span class="material-symbols-outlined">groups</span>
                </div>
                <span class="bg-slate-100 text-slate-700 text-[10px] font-bold px-2 py-1 rounded-full uppercase tracking-wide">Próximamente</span>
            </div>
            <div>
                <h4 class="text-lg font-bold text-slate-900">Población Flotante</h4>
                <p class="text-sm text-slate-500 mt-1">Análisis de movimiento temporal y estacionalidad.</p>
            </div>
            <div class="pt-2 mt-auto">
                <button disabled class="w-full h-10 bg-slate-200 text-slate-500 rounded-lg font-semibold text-sm">
                    Ver el Tablero
                </button>
            </div>
        </article>
    </div>
</section>
</div>
