<div class="group relative overflow-hidden rounded-2xl border border-[var(--color-app-border)] bg-white p-5 shadow-sm transition hover:shadow-md dark:border-[var(--color-app-dark-border)] dark:bg-[var(--color-app-dark-surface)]">
    <div class="absolute inset-x-0 top-0 h-1 bg-[var(--color-senatur-blue)]"></div>

    <div class="space-y-3">
        <div class="flex items-start justify-between gap-3">
            <div class="text-sm font-medium text-gray-500 dark:text-slate-300">
                {{ $title }}
            </div>

            @isset($badge)
                <span class="rounded-full bg-blue-50 px-2.5 py-1 text-[11px] font-semibold text-[var(--color-senatur-blue)] dark:bg-blue-500/15 dark:text-blue-200">
                    {{ $badge }}
                </span>
            @endisset
        </div>

        <div class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white">
            {{ $value }}
            @isset($unit)
                <span class="ml-1 text-sm font-medium text-gray-500 dark:text-slate-300">{{ $unit }}</span>
            @endisset
        </div>

        @isset($helpText)
            <div class="text-xs text-gray-500 dark:text-slate-400">
                {{ $helpText }}
            </div>
        @endisset

        @isset($source)
            <div class="text-[11px] text-gray-400 dark:text-slate-500">
                Fuente: {{ $source }}
            </div>
        @endisset
    </div>
</div>
