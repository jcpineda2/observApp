@props([
    'message' => 'Actualizando datos...',
    'minHeight' => '220px',
])

<div
    class="flex items-center justify-center rounded-2xl border border-gray-200 bg-white p-8 text-center shadow-sm dark:border-slate-800 dark:bg-slate-900"
    style="min-height: {{ $minHeight }}"
>
    <div class="space-y-3">
        <div class="mx-auto h-8 w-8 animate-spin rounded-full border-2 border-gray-300 border-t-[var(--color-senatur-blue)] dark:border-slate-700 dark:border-t-slate-200"></div>

        <p class="text-sm text-gray-500 dark:text-slate-400">
            {{ $message }}
        </p>
    </div>
</div>
