@props([
    'title',
    'description' => null,
])

<div class="mb-6">
    <h2 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
        {{ $title }}
    </h2>

    @if ($description)
        <p class="mt-2 max-w-3xl text-sm leading-6 text-gray-600 dark:text-slate-300">
            {{ $description }}
        </p>
    @endif
</div>
