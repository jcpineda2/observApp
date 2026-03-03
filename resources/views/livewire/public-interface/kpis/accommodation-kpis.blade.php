@php
    $items = [
        [
            'title' => 'Establecimientos registrados',
            'value' => number_format($accommodationsCount, 0, ',', '.'),
        ],
        [
            'title' => 'Ocupación promedio',
            'value' => number_format($avgOccupancyRate, 2, ',', '.') . '%',
        ],
        [
            'title' => 'Categorías registradas',
            'value' => number_format($categoriesCount, 0, ',', '.'),
        ],
        [
            'title' => 'Temporada dominante',
            'value' => $dominantSeason ?? '—',
        ],
    ];

@endphp
<livewire:public-interface.kpi-grid :items="$items" />
