<div class="rounded-2xl bg-white p-4 shadow-sm ring-1 ring-gray-200">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <h3 class="text-sm font-semibold text-gray-900">Filtros</h3>
            <p class="mt-1 text-xs text-gray-500">
                Selecciona año y mes para actualizar KPIs y gráficos.
            </p>
        </div>

        <div class="grid w-full gap-3 sm:w-auto sm:grid-cols-3">
            {{-- Año --}}
            <div class="sm:min-w-56">
                <label class="block text-xs font-medium text-gray-600">Año</label>
                <select
                    wire:model.live="year"
                    class="mt-1 w-full rounded-lg border-gray-200 bg-white px-3 py-2 text-sm shadow-sm focus:border-blue-600 focus:ring-blue-600"
                >
                    <option value="">Todos</option>
                    @foreach($yearOptions as $id => $label)
                        <option value="{{ $id }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Mes --}}
            <div class="sm:min-w-56">
                <label class="block text-xs font-medium text-gray-600">Mes</label>
                <select
                    wire:model.live="month"
                    class="mt-1 w-full rounded-lg border-gray-200 bg-white px-3 py-2 text-sm shadow-sm focus:border-blue-600 focus:ring-blue-600"
                >
                    <option value="">Todos</option>
                    @foreach($monthOptions as $id => $label)
                        <option value="{{ $id }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Reset --}}
            <div class="sm:min-w-40">
                <button
                    type="button"
                    wire:click="resetFilters"
                    class="mt-5 w-full rounded-lg bg-gray-900 px-3 py-2 text-sm font-medium text-white hover:bg-gray-800 cursor-pointer"
                >
                    Limpiar
                </button>
            </div>
        </div>
    </div>

    {{-- Chip de estado (UX) --}}
    <div class="mt-4 flex flex-wrap gap-2 text-xs">
        <span class="rounded-full bg-gray-100 px-3 py-1 text-gray-700 ring-1 ring-gray-200">
            Año: <strong>{{ $year ? ($yearOptions[$year] ?? '—') : 'Todos' }}</strong>
        </span>

        <span class="rounded-full bg-gray-100 px-3 py-1 text-gray-700 ring-1 ring-gray-200">
            Mes: <strong>{{ $month ? ($monthOptions[$month] ?? '—') : 'Todos' }}</strong>
        </span>
    </div>
</div>
