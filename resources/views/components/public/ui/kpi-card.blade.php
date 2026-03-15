@props([
    'title',
    'value' => '0',
    'badge' => null,
    'helpText' => null,
])

<div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
    <div class="flex items-start justify-between gap-3">
        <div>
            <p class="text-sm font-medium text-gray-500 dark:text-slate-400">
                {{ $title }}
            </p>

            <p class="mt-3 text-3xl font-bold tracking-tight text-gray-900 dark:text-white">
                {{ $value }}
            </p>
        </div>

        @if ($badge)
            <span class="inline-flex items-center rounded-full bg-blue-50 px-2.5 py-1 text-xs font-semibold text-[var(--color-senatur-blue)] dark:bg-slate-800 dark:text-slate-200">
                {{ $badge }}
            </span>
        @endif
    </div>

    @if ($helpText)
        <p class="mt-3 text-sm text-gray-500 dark:text-slate-400">
            {{ $helpText }}
        </p>
    @endif
</div>
