@php
    $items = [
        ['title' => 'Total nacional PST (stock)', 'value' => number_format($totalRegistered, 0, ',', '.')],
        ['title' => 'Altas (período)', 'value' => number_format($registrations, 0, ',', '.')],
        ['title' => 'Bajas (período)', 'value' => number_format($cancellations, 0, ',', '.')],
        ['title' => '% Formalización', 'value' => number_format($formalizationPct, 2, ',', '.') . '%'],
    ];
@endphp

<livewire:public-interface.kpi-grid :items="$items" />
