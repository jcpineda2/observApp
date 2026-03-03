@php
    $metricLabel = $metric === 'flights' ? 'Vuelos' : 'Asientos';

    $cfg = [
        'type' => 'bar',
        'data' => ['labels' => $labels, 'datasets' => $datasets],
        'options' => [
            'indexAxis' => 'y',
            'responsive' => true,
            'maintainAspectRatio' => false,
            'animation' => false,
            'plugins' => ['legend' => ['display' => false]],
            'scales' => [
                'x' => ['beginAtZero' => true],
                'y' => ['grid' => ['display' => false]],
            ],
        ],
    ];
@endphp

<div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-gray-200">
    <div class="flex items-start justify-between gap-3">
        <div>
            <h3 class="text-sm font-semibold text-gray-900">Top Aerolíneas</h3>
            <p class="mt-1 text-xs text-gray-500">
                Ranking por {{ strtolower($metricLabel) }} (Top {{ $limit }})
            </p>
        </div>
        <div class="h-9 w-9 rounded-xl bg-blue-800/10 ring-1 ring-blue-800/10"></div>
    </div>

    <div class="mt-4">
        <div class="relative w-full" style="height: 360px;"
            x-data="observatorioChart(@js($cfg), '{{ $chartId }}')"
            x-init="init($refs.canvas)"
            wire:ignore>
            <canvas x-ref="canvas" id="{{ $chartId }}"></canvas>
        </div>
    </div>
</div>
