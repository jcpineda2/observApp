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

    <h3 class="text-sm font-semibold text-gray-900">
        Llegadas de turistas por mes
    </h3>

    <p class="mt-1 text-xs text-gray-500">
        Evolución mensual del turismo receptivo.
    </p>

    <div class="mt-4">
        <div
            class="relative w-full"
            style="height: 320px;"
            x-data="observatorioChart(@js($config), '{{ $chartId }}')"
            x-init="init($refs.canvas)"
            wire:ignore
        >
            <canvas x-ref="canvas" id="{{ $chartId }}"></canvas>
        </div>
    </div>

</div>
