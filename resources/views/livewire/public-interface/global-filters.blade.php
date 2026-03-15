<div class="ui-surface p-5 sm:p-6">

    <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">

        <div>
            <h3 class="ui-heading text-base">Filtros</h3>

            <p class="ui-text-muted mt-1 text-sm">
                Selecciona año y mes para actualizar KPIs, gráficos y mapas.
            </p>
        </div>

        <div class="grid w-full gap-3 sm:grid-cols-3 lg:w-auto">

            {{-- Año --}}
            <div class="sm:min-w-52">
                <label class="block text-xs font-medium text-gray-600 dark:text-slate-300">
                    Año
                </label>

                <select wire:model.live="year" class="ui-select">
                    <option value="">Todos</option>

                    @foreach($yearOptions as $id => $label)
                        <option value="{{ $id }}">
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Mes --}}
            <div class="sm:min-w-52">
                <label class="block text-xs font-medium text-gray-600 dark:text-slate-300">
                    Mes
                </label>

                <select wire:model.live="month" class="ui-select">
                    <option value="">Todos</option>

                    @foreach($monthOptions as $id => $label)
                        <option value="{{ $id }}">
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Limpiar --}}
            <div class="sm:min-w-40">
                <button
                    type="button"
                    wire:click="resetFilters"
                    class="mt-5 w-full ui-btn-primary"
                >
                    Limpiar
                </button>
            </div>

        </div>
    </div>

    {{-- Estado de filtros --}}
    <div class="mt-4 flex flex-wrap gap-2 text-xs">

        <span class="rounded-full bg-gray-100 px-3 py-1 text-gray-700 ring-1 ring-gray-200 dark:bg-slate-700 dark:text-slate-100 dark:ring-[var(--color-app-dark-border)]">
            Año:
            <strong>
                {{ $year ? ($yearOptions[$year] ?? '—') : 'Todos' }}
            </strong>
        </span>

        <span class="rounded-full bg-gray-100 px-3 py-1 text-gray-700 ring-1 ring-gray-200 dark:bg-slate-700 dark:text-slate-100 dark:ring-[var(--color-app-dark-border)]">
            Mes:
            <strong>
                {{ $month ? ($monthOptions[$month] ?? '—') : 'Todos' }}
            </strong>
        </span>

    </div>

</div>
