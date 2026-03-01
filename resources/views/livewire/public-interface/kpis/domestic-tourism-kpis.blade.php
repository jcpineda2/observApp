@php
    $items = [
        [
            'title' => 'Turistas internos',
            'value' => number_format($tourists, 0, ',', '.'),
            'subtitle' => $month ? 'Año + Mes' : 'Año',
        ],
        [
            'title' => 'Gasto turístico interno',
            'value' => number_format($totalSpend, 0, ',', '.'),
            'subtitle' => 'Suma (total_spend)',
        ],
        [
            'title' => 'Estadía promedio (simple)',
            'value' => number_format($avgStaySimple, 2, ',', '.'),
            'subtitle' => 'AVG(average_stay)',
        ],
        [
            'title' => 'Estadía promedio (ponderada)',
            'value' => number_format($avgStayWeighted, 2, ',', '.'),
            'subtitle' => 'Σ(stay*qty) / Σ(qty)',
        ],
    ];
@endphp

<livewire:public-interface.kpi-grid :items="$items" />
