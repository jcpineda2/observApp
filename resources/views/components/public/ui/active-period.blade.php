@props([
    'yearLabel' => null,
    'monthLabel' => null,
])

<div class="inline-flex items-center gap-2 rounded-full border border-gray-200 bg-white px-4 py-2 text-sm text-gray-700 shadow-sm dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200">
    <span class="font-semibold">Período analizado:</span>

    <span>
        {{ $yearLabel ?? 'Todos los años' }}
        @if ($monthLabel)
            · {{ $monthLabel }}
        @else
            · Todos los meses
        @endif
    </span>
</div>
