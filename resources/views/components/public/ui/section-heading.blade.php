@props([
    'title',
    'description' => null,
    'eyebrow' => null,
])

<div class="space-y-2">
    @if ($eyebrow)
        <p class="text-xs font-semibold uppercase tracking-[0.18em] text-[var(--color-senatur-blue)] dark:text-slate-300">
            {{ $eyebrow }}
        </p>
    @endif

    <div>
        <h1 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-3xl">
            {{ $title }}
        </h1>

        @if ($description)
            <p class="mt-2 max-w-3xl text-sm leading-6 text-gray-600 dark:text-slate-300 sm:text-base">
                {{ $description }}
            </p>
        @endif
    </div>
</div>
