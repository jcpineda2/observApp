@php
    $cfg = [
        'type' => 'doughnut',
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
        ],
    ];
@endphp

<div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-gray-200">
    <div class="flex items-start justify-between gap-4">
        <div>
            <h3 class="text-sm font-semibold text-gray-900">Distribución por género</h3>
            <p class="mt-1 text-xs text-gray-500">Empleo turístico (personas)</p>
        </div>

        <div class="text-right">
            <span class="text-xs text-gray-500 block">Total</span>
            <span class="text-lg font-bold text-gray-900">
                {{ number_format($totalPeople, 0, ',', '.') }}
            </span>
        </div>
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
