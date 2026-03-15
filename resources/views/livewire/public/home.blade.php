<section class="py-10 lg:py-14">
    <div class="grid gap-8 lg:grid-cols-[1.2fr_0.8fr] lg:items-center">
        <div>
            <span class="inline-flex items-center rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-[var(--color-senatur-blue)] dark:bg-slate-800 dark:text-slate-200">
                Observatorio Turístico
            </span>

            <h1 class="mt-4 text-4xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-5xl">
                Datos e indicadores para entender el turismo en Paraguay
            </h1>

            <p class="mt-4 max-w-2xl text-base leading-7 text-gray-600 dark:text-slate-300 sm:text-lg">
                Explora estadísticas de turismo interno, turismo receptivo, empleo, alojamientos,
                conectividad y prestadores. Utiliza los filtros globales para analizar la información
                por año y mes.
            </p>

            <div class="mt-8 flex flex-wrap gap-3">
                <a
                    wire:navigate
                    href="{{ route('public.inbound') }}"
                    class="inline-flex items-center rounded-xl bg-[var(--color-senatur-blue)] px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:opacity-90"
                >
                    Ver turismo receptivo
                </a>

                <a
                    wire:navigate
                    href="{{ route('public.domestic') }}"
                    class="inline-flex items-center rounded-xl border border-gray-200 bg-white px-5 py-3 text-sm font-semibold text-gray-700 transition hover:bg-gray-50 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100 dark:hover:bg-slate-800"
                >
                    Ver turismo interno
                </a>
            </div>
        </div>

        <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                Secciones disponibles
            </h2>

            <div class="mt-5 grid gap-3 sm:grid-cols-2">
                <a wire:navigate href="{{ route('public.domestic') }}" class="rounded-2xl border border-gray-200 p-4 transition hover:bg-gray-50 dark:border-slate-700 dark:hover:bg-slate-800">
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Turismo interno</h3>
                    <p class="mt-1 text-sm text-gray-600 dark:text-slate-300">Movilidad y comportamiento interno.</p>
                </a>

                <a wire:navigate href="{{ route('public.inbound') }}" class="rounded-2xl border border-gray-200 p-4 transition hover:bg-gray-50 dark:border-slate-700 dark:hover:bg-slate-800">
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Turismo receptivo</h3>
                    <p class="mt-1 text-sm text-gray-600 dark:text-slate-300">Llegadas, origen y motivo de viaje.</p>
                </a>

                <a wire:navigate href="{{ route('public.providers') }}" class="rounded-2xl border border-gray-200 p-4 transition hover:bg-gray-50 dark:border-slate-700 dark:hover:bg-slate-800">
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Prestadores</h3>
                    <p class="mt-1 text-sm text-gray-600 dark:text-slate-300">Oferta turística registrada.</p>
                </a>

                <a wire:navigate href="{{ route('public.accommodation') }}" class="rounded-2xl border border-gray-200 p-4 transition hover:bg-gray-50 dark:border-slate-700 dark:hover:bg-slate-800">
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Alojamientos</h3>
                    <p class="mt-1 text-sm text-gray-600 dark:text-slate-300">Capacidad y desempeño del sector.</p>
                </a>

                <a wire:navigate href="{{ route('public.employment') }}" class="rounded-2xl border border-gray-200 p-4 transition hover:bg-gray-50 dark:border-slate-700 dark:hover:bg-slate-800">
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Empleo</h3>
                    <p class="mt-1 text-sm text-gray-600 dark:text-slate-300">Indicadores laborales del turismo.</p>
                </a>

                <a wire:navigate href="{{ route('public.connectivity') }}" class="rounded-2xl border border-gray-200 p-4 transition hover:bg-gray-50 dark:border-slate-700 dark:hover:bg-slate-800">
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Conectividad</h3>
                    <p class="mt-1 text-sm text-gray-600 dark:text-slate-300">Rutas, aerolíneas y conexiones.</p>
                </a>
            </div>
        </div>
    </div>
</section>
