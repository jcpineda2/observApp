@php
    $cfg = [
        'type' => 'bar',
        'data' => [
            'labels' => $labels,
            'datasets' => $datasets,
        ],
        'options' => [
            'responsive' => true,
            'maintainAspectRatio' => false,
            'animation' => false,
            'plugins' => [
                'legend' => ['display' => false],
            ],
            'scales' => [
                'x' => ['grid' => ['display' => false]],
                'y' => ['beginAtZero' => true],
            ],
        ],
    ];
@endphp

<div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-gray-200">
    <div class="flex items-start justify-between gap-3">
        <div>
            <h3 class="text-sm font-semibold text-gray-900">Turistas internos por región de origen</h3>
            <p class="mt-1 text-xs text-gray-500">Top 10 + Otros (según filtro Año/Mes)</p>
        </div>
        <div class="h-9 w-9 rounded-xl bg-blue-800/10 ring-1 ring-blue-800/10"></div>
    </div>

    <div class="mt-4">
        <div
            class="relative w-full"
            style="height: 320px;"
            x-data="observatorioChart(@js($cfg), '{{ $chartId }}')"
            x-init="init($refs.canvas)"
            wire:ignore
        >
            <canvas x-ref="canvas" id="{{ $chartId }}"></canvas>
        </div>
    </div>
</div>
