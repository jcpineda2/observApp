@props([
    'title',
    'subtitle' => null,
    'chartId',
    'type' => 'bar',
    'labels' => [],
    'datasets' => [],
    'height' => 320,
    'bodyClass' => 'public-chart-standard',
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
            'scales' => in_array($type, ['bar', 'line'])
                ? [
                    'x' => [
                        'grid' => [
                            'display' => false,
                        ],
                    ],
                    'y' => [
                        'beginAtZero' => true,
                    ],
                ]
                : new stdClass(),
        ],
    ];
@endphp

<div class="chart-card">
    <div class="chart-card-header">
        <div>
            <h3 class="chart-card-title">
                {{ $title }}
            </h3>

            @if ($subtitle)
                <p class="chart-card-subtitle">
                    {{ $subtitle }}
                </p>
            @endif
        </div>
    </div>

    <div @class(['chart-card-body', $bodyClass])>
        @if (empty($labels) || empty($datasets))
            <div class="public-empty-state">
                Debe aplicar un filtro para visualizar los gráficos.
            </div>
        @else
            <div
                class="relative w-full"
                style="height: {{ $height }}px;"
                x-data="observatorioChart(@js($config), '{{ $chartId }}')"
                x-init="init($refs.canvas)"
                wire:ignore
            >
                <canvas x-ref="canvas" id="{{ $chartId }}"></canvas>
            </div>
        @endif
    </div>
</div>
