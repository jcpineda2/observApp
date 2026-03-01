<section class="rounded-2xl border bg-white p-6 shadow-sm">
    {{-- Hero --}}
    <div class="grid gap-6 lg:grid-cols-12 lg:items-center">
        <div class="lg:col-span-7">
            <div class="inline-flex items-center gap-2 rounded-full bg-blue-50 px-3 py-1 text-xs font-medium text-blue-800">
                <span class="h-2 w-2 rounded-full bg-blue-800"></span>
                Observatorio Turístico - Registur
            </div>

            <h1 class="mt-3 text-2xl font-semibold tracking-tight sm:text-3xl">
                Estadísticas y métricas del turismo, en un solo lugar
            </h1>

            <p class="mt-3 text-sm leading-6 text-gray-600">
                Visualizá indicadores clave por eje (turismo interno, receptivo, prestadores, alojamientos, empleo y conectividad),
                con filtros por período y segmentaciones definidas por el cliente.
            </p>

            {{-- CTAs --}}
            <div class="mt-5 flex flex-wrap gap-3">
                <a href="#turismo-interno"
                   class="inline-flex items-center justify-center rounded-xl bg-blue-800 px-4 py-2 text-sm font-medium text-white hover:bg-blue-900 transition">
                    Ver tableros
                </a>

                <a href="#principal"
                   class="inline-flex items-center justify-center rounded-xl border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-800 hover:bg-gray-50 transition">
                    Acerca del observatorio
                </a>

                <a href="{{ url('/admin') }}"
                   class="inline-flex items-center justify-center rounded-xl border border-blue-200 bg-blue-50 px-4 py-2 text-sm font-medium text-blue-800 hover:bg-blue-100 transition">
                    Acceder al panel
                </a>
            </div>

            {{-- Accesos rápidos (chips) --}}
            <div class="mt-6">
                <div class="text-xs font-semibold uppercase tracking-wide text-gray-500">Accesos rápidos</div>

                <div class="mt-2 flex flex-wrap gap-2">
                    @foreach ($quickLinks as $link)
                        <a href="#{{ $link['id'] }}"
                           class="rounded-full bg-gray-100 px-3 py-1 text-sm text-gray-700 hover:bg-gray-200 transition">
                            {{ $link['label'] }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Panel visual derecho (placeholder) --}}
        <div class="lg:col-span-5">
            <div class="relative overflow-hidden rounded-2xl border bg-gradient-to-br from-blue-50 to-white p-5">
                <div class="text-sm font-medium text-gray-800">Resumen</div>
                <p class="mt-1 text-xs text-gray-600">
                    En fase 2 aquí puede ir un mini-gráfico, mapa o tendencia.
                </p>

                <div class="mt-4 grid grid-cols-2 gap-3">
                    <div class="rounded-xl border bg-white p-3">
                        <div class="text-[11px] text-gray-500">Evolución</div>
                        <div class="mt-2 h-10 rounded bg-gray-100"></div>
                    </div>
                    <div class="rounded-xl border bg-white p-3">
                        <div class="text-[11px] text-gray-500">Mapa</div>
                        <div class="mt-2 h-10 rounded bg-gray-100"></div>
                    </div>
                </div>

                <div class="pointer-events-none absolute -right-10 -top-10 h-32 w-32 rounded-full bg-blue-100 blur-2xl"></div>
            </div>
        </div>
    </div>

    {{-- KPIs --}}
    <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        @foreach ($kpis as $kpi)
            <div class="rounded-2xl border p-4">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <div class="text-xs font-medium text-gray-500">{{ $kpi['label'] }}</div>
                        <div class="mt-2 text-2xl font-semibold tracking-tight">{{ $kpi['value'] }}</div>
                        <div class="mt-1 text-xs text-gray-500">{{ $kpi['hint'] }}</div>
                    </div>

                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50 text-blue-800">
                        {{-- Icon placeholder --}}
                        <span class="text-sm font-bold">•</span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>
