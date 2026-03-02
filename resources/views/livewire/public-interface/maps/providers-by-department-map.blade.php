<div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-gray-200">
    <div class="flex items-start justify-between gap-3">
        <div>
            <h3 class="text-sm font-semibold text-gray-900">Prestadores por departamento</h3>
            <p class="mt-1 text-xs text-gray-500">Mapa + ranking (Top 10 + Otros). GeoJSON local.</p>
        </div>
        <div class="h-9 w-9 rounded-xl bg-blue-800/10 ring-1 ring-blue-800/10"></div>
    </div>

    <div class="mt-4 grid gap-4 lg:grid-cols-3">
        {{-- MAPA --}}
        <div
            class="lg:col-span-2 relative w-full overflow-hidden rounded-xl ring-1 ring-gray-200"
            style="height: 440px;"
            x-data="observatorioDepartmentMap({
                mapId: '{{ $mapId }}',
                geojsonUrl: '{{ $geojsonUrl }}'
            })"
            x-init="init()"
            wire:ignore
        ></div>

        {{-- RANKING --}}
        <div
            class="rounded-xl ring-1 ring-gray-200 p-4"
            x-data="observatorioDeptRanking('{{ $mapId }}')"
            x-init="init()"
            wire:ignore
        >
            <div class="flex items-center justify-between">
                <h4 class="text-sm font-semibold text-gray-900">Top departamentos</h4>
                <span class="text-xs text-gray-500">Stock PST</span>
            </div>

            <div class="mt-3 space-y-2">
                <template x-for="(item, idx) in ranking" :key="idx">
                    <div class="flex items-center gap-3">
                        <div class="min-w-0 flex-1">
                            <div class="flex items-center justify-between gap-2">
                                <p class="truncate text-xs font-medium text-gray-800" x-text="item.label"></p>
                                <p class="text-xs tabular-nums text-gray-900" x-text="format(item.value)"></p>
                            </div>
                            <div class="mt-1 h-1.5 w-full rounded-full bg-gray-100 overflow-hidden">
                                <div
                                    class="h-full rounded-full bg-blue-800/60"
                                    :style="`width: ${pct(item.value)}%`"
                                ></div>
                            </div>
                        </div>
                    </div>
                </template>

                <template x-if="!ranking.length">
                    <p class="text-xs text-gray-500">Sin datos para el período seleccionado.</p>
                </template>
            </div>
        </div>
    </div>
</div>
