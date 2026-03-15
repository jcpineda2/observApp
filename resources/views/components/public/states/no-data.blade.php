@props([
    'title' => 'Sin datos disponibles',
    'message' => 'No existen registros para los filtros seleccionados.',
])

<div class="rounded-2xl border border-dashed border-gray-300 bg-gray-50 p-8 text-center dark:border-slate-700 dark:bg-slate-900">
    <h3 class="text-base font-semibold text-gray-900 dark:text-white">
        {{ $title }}
    </h3>

    <p class="mt-2 text-sm text-gray-600 dark:text-slate-300">
        {{ $message }}
    </p>
</div>
