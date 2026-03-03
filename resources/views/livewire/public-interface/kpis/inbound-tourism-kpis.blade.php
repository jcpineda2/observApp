@php
    $items = [
        [
            'title' => 'Turistas internacionales',
            'value' => number_format($tourists, 0, ',', '.'),
        ],
        [
            'title' => 'Excursionistas',
            'value' => number_format($excursionists, 0, ',', '.'),
        ],
        [
            'title' => 'Divisas generadas',
            'value' => number_format($foreignExchange, 0, ',', '.'),
        ],
        [
            'title' => 'Gasto promedio',
            'value' => number_format($avgSpend, 2, ',', '.'),
        ],
        [
            'title' => 'Estadía promedio',
            'value' => number_format($avgStay, 2, ',', '.'),
        ],
    ];
@endphp

<livewire:public-interface.kpi-grid :items="$items" />
