@props([
    'title',
    'subtitle' => null,
    'chartId',
    'type' => 'bar',
    'labels' => [],
    'datasets' => [],
    'height' => 320,
])

@php
    $config = [
        'type' => $type,
        'data' => [
            'labels' => $labels,
            'datasets' => $datasets,
        ],
        'options' => [
            'responsive' => true,
            'maintainAspectRatio' => false,
            'animation' => false,
            'plugins' => [
                'legend' => [
                    'position' => 'bottom',
                ],
            ],
            'scales' => in_array($type, ['bar', 'line']) ? [
                'x' => [
                    'grid' => [
                        'display' => false,
                    ],
                ],
                'y' => [
                    'beginAtZero' => true,
                ],
            ] : new stdClass(),
        ],
    ];
@endphp

<div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-gray-200">
    <div class="flex items-start justify-between gap-3">
        <div>
            <h3 class="text-sm font-semibold text-gray-900">
                {{ $title }}
            </h3>

            @if ($subtitle)
                <p class="mt-1 text-xs text-gray-500">
                    {{ $subtitle }}
                </p>
            @endif
        </div>
    </div>

    <div class="mt-4">
        <div
            class="relative w-full"
            style="height: {{ $height }}px;"
            x-data="observatorioChart(@js($config), '{{ $chartId }}')"
            x-init="init($refs.canvas)"
            wire:ignore
        >
            <canvas x-ref="canvas" id="{{ $chartId }}"></canvas>
        </div>
    </div>
</div>
