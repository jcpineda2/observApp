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
                'legend' => ['position' => 'bottom'],
            ],
            'scales' => [
                'x' => ['grid' => ['display' => false]],
                'y' => ['beginAtZero' => true],
            ],
        ],
    ];
@endphp

<div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-gray-200">
    <h3 class="text-sm font-semibold text-gray-900">Variación interanual (YoY) del stock de prestadores</h3>
    <p class="mt-1 text-xs text-gray-500">Comparación contra el mismo mes del año anterior</p>

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
