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
            'animation' => false,
            'plugins' => [
                'legend' => ['position' => 'bottom'],
            ],
            'scales' => [
                'x' => ['grid' => ['display' => false]],
                'y' => ['beginAtZero' => false],
            ],
        ],
    ];
@endphp

<div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-gray-200">
    <div class="flex items-start justify-between gap-4">
        <div>
            <h3 class="text-sm font-semibold text-gray-900">Variación interanual del empleo turístico</h3>
            <p class="mt-1 text-xs text-gray-500">YoY% promedio anual</p>
        </div>

        <div class="text-right">
            <span class="text-xs text-gray-500 block">
                Último YoY{{ $latestYearLabel ? " ($latestYearLabel)" : '' }}
            </span>
            <span class="text-lg font-bold {{ $latestYoY >= 0 ? 'text-emerald-600' : 'text-red-600' }}">
                {{ number_format($latestYoY, 2, ',', '.') }}%
            </span>
        </div>
    </div>

    <div class="mt-4">
        <div
            class="relative w-full"
            style="height: 340px;"
            x-data="observatorioChart(@js($cfg), '{{ $chartId }}')"
            x-init="init($refs.canvas)"
            wire:ignore
        >
            <canvas x-ref="canvas" id="{{ $chartId }}"></canvas>
        </div>
    </div>
</div>
