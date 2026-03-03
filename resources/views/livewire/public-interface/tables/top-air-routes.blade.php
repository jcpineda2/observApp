<div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-gray-200">
    <div class="flex items-start justify-between gap-3">
        <div>
            <h3 class="text-sm font-semibold text-gray-900">Top Rutas (Origen → Destino)</h3>
            <p class="mt-1 text-xs text-gray-500">
                Ranking por asientos (Top {{ $limit }}) — incluye vuelos y estado
            </p>
        </div>
        <div class="h-9 w-9 rounded-xl bg-blue-800/10 ring-1 ring-blue-800/10"></div>
    </div>

    <div class="mt-4 overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="text-left text-xs text-gray-500">
                <tr class="border-b">
                    <th class="py-2 pr-3">#</th>
                    <th class="py-2 pr-3">Ruta</th>
                    <th class="py-2 pr-3">Aerolínea</th>
                    <th class="py-2 pr-3 text-right">Vuelos</th>
                    <th class="py-2 pr-3 text-right">Asientos</th>
                    <th class="py-2 pr-3 text-right">Estado</th>
                </tr>
            </thead>

            <tbody class="divide-y">
                @forelse($rows as $r)
                    <tr class="hover:bg-gray-50">
                        <td class="py-2 pr-3 font-medium text-gray-900">{{ $r['rank'] }}</td>
                        <td class="py-2 pr-3 text-gray-900">{{ $r['route'] }}</td>
                        <td class="py-2 pr-3 text-gray-700">{{ $r['airline'] }}</td>
                        <td class="py-2 pr-3 text-right text-gray-700">
                            {{ number_format($r['flights'], 0, ',', '.') }}
                        </td>
                        <td class="py-2 pr-3 text-right font-semibold text-gray-900">
                            {{ number_format($r['seats'], 0, ',', '.') }}
                        </td>
                        <td class="py-2 pr-3 text-right">
                            @if($r['is_active'])
                                <span class="inline-flex items-center rounded-full bg-emerald-50 px-2 py-1 text-xs font-medium text-emerald-700 ring-1 ring-emerald-100">
                                    Activa
                                </span>
                            @else
                                <span class="inline-flex items-center rounded-full bg-gray-50 px-2 py-1 text-xs font-medium text-gray-700 ring-1 ring-gray-200">
                                    Inactiva
                                </span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-6 text-center text-gray-500">
                            No hay datos para los filtros seleccionados.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
