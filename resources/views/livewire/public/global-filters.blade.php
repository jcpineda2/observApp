<x-public.ui.filter-panel>
    <div class="grid gap-4 md:grid-cols-2">
        <div>
            <label for="year" class="mb-2 block text-sm font-medium text-gray-700 dark:text-slate-300">
                Año
            </label>

            <select
                id="year"
                wire:model.live="year"
                class="ui-select"
            >
                @foreach ($years as $item)
                    <option value="{{ $item->id }}">{{ $item->year }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="month" class="mb-2 block text-sm font-medium text-gray-700 dark:text-slate-300">
                Mes
            </label>

            <select
                id="month"
                wire:model.live="month"
                class="ui-select">
                <option value="">Todos</option>

                @foreach ($months as $item)
                    <option value="{{ $item->id }}">{{ $item->month }}</option>
                @endforeach
            </select>
        </div>
    </div>
</x-public.ui.filter-panel>
