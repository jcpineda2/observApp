@props([
    'title',
    'subtitle' => null,
    'emptyMessage' => 'Sin datos para los filtros seleccionados.',
])

<div class="ui-surface p-5 sm:p-6">
    <div class="space-y-1">
        <h3 class="ui-heading text-base">
            {{ $title }}
        </h3>

        @if ($subtitle)
            <p class="ui-text-muted text-sm">
                {{ $subtitle }}
            </p>
        @endif
    </div>

    <div class="mt-5">
        {{ $slot }}
    </div>
</div>
