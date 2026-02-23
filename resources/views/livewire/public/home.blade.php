<div class="space-y-6">
    {{-- Hero --}}
    <section class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
        <span class="text-xs font-semibold tracking-wider text-primary uppercase">Datos Oficiales</span>
        <h1 class="text-3xl font-bold text-slate-900 mt-2">Observatorio Turístico</h1>
        <p class="text-slate-500 mt-2 max-w-2xl">
            Plataforma de información estadística del turismo en Paraguay.
        </p>

        <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <a href="{{ route('public.domestic') }}"
               class="rounded-2xl border border-slate-100 p-4 hover:shadow-sm transition">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-orange-500">tour</span>
                    <span class="font-semibold">Turismo Interno</span>
                </div>
                <p class="text-sm text-slate-500 mt-2">
                    Movilidad turística de residentes dentro del país. :contentReference[oaicite:6]{index=6}
                </p>
            </a>

            <a href="{{ route('public.inbound') }}"
               class="rounded-2xl border border-slate-100 p-4 hover:shadow-sm transition">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-purple-500">flight_land</span>
                    <span class="font-semibold">Turismo Receptivo</span>
                </div>
                <p class="text-sm text-slate-500 mt-2">
                    Turistas internacionales que ingresan al país. :contentReference[oaicite:7]{index=7}
                </p>
            </a>

            <div class="rounded-2xl border border-slate-100 p-4 opacity-70">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-teal-600">flight</span>
                    <span class="font-semibold">Conectividad</span>
                </div>
                <p class="text-sm text-slate-500 mt-2">
                    Próximamente (según esquema del observatorio). :contentReference[oaicite:8]{index=8}
                </p>
            </div>
        </div>
    </section>

    {{-- Ejes / explicación --}}
    <section class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <h2 class="text-lg font-bold">¿Qué es esta plataforma?</h2>
            <p class="text-sm text-slate-500 mt-2">
                Explicación general del observatorio, metodología y alcance.
            </p>
        </div>

        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <h2 class="text-lg font-bold">Accesos rápidos</h2>
            <p class="text-sm text-slate-500 mt-2">
                Entrá a los tableros para filtrar por año/mes y ver rankings.
            </p>
        </div>
    </section>
</div>
