@props([
    'title',
    'subtitle' => null,
    'padding' => true,
])

<div class="rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
    <div class="border-b border-gray-100 px-5 py-4 dark:border-slate-800">
        <h3 class="text-base font-semibold text-gray-900 dark:text-white">
            {{ $title }}
        </h3>

        @if ($subtitle)
            <p class="mt-1 text-sm text-gray-500 dark:text-slate-400">
                {{ $subtitle }}
            </p>
        @endif
    </div>

    <div @class([
        'p-5' => $padding,
    ])>
        {{ $slot }}
    </div>
</div>
