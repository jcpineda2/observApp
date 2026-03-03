@php
    $chartConfig = [
        'type' => $type,
        'data' => [
            'labels' => $labels,
            'datasets' => $datasets,
        ],
        'options' => [
            'responsive' => true,
            'maintainAspectRatio' => false,
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'bottom',
                ],
                'tooltip' => [
                    'enabled' => true,
                ],
            ],
            'scales' => in_array($type, ['bar', 'line'])
                ? [
                    'x' => ['grid' => ['display' => false]],
                    'y' => ['beginAtZero' => true],
                ]
                : new stdClass(),
        ],
    ];
@endphp

<div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-gray-200">
    <div class="flex items-start justify-between gap-3">
        <div>
            <h3 class="text-sm font-semibold text-gray-900">{{ $title }}</h3>
            @if($subtitle)
                <p class="mt-1 text-xs text-gray-500">{{ $subtitle }}</p>
            @endif
        </div>

        {{-- Accent semántico (luego lo cambiamos por brand real) --}}
        <div class="h-9 w-9 rounded-xl bg-blue-800/10 ring-1 ring-blue-800/10"></div>
    </div>

    <div class="mt-4">
        <div
            class="relative w-full"
            style="height: {{ $height }}px;"
            x-data="registurChart(@js($chartConfig))"
            x-init="init($refs.canvas)"
            wire:ignore
        >
            <canvas x-ref="canvas" id="{{ $chartId }}"></canvas>
        </div>
    </div>
</div>
