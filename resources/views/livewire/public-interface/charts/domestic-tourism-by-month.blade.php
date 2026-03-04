@php
    $cfg = [
        'type' => 'line',
        'data' => [
            'labels' => $labels,
            'datasets' => $datasets,
        ],
        'options' => [
            'responsive' => true,
            'maintainAspectRatio' => false,
            'plugins' => [
                'legend' => ['position' => 'bottom']
            ],
        ],
    ];
@endphp

<div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-gray-200">
    <h3 class="text-sm font-semibold text-gray-900">Título del gráfico</h3>

    <div class="mt-4">
        <div
            class="relative w-full"
            style="height: 280px;"
            x-data="observatorioChart(@j    s($cfg), '{{ $chartId }}')"
            x-init="init()"
            wire:ignore
        >
            <canvas id="{{ $chartId }}"></canvas>
        </div>
    </div>
</div>
