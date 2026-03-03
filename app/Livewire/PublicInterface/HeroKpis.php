<?php

namespace App\Livewire\PublicInterface;

use Livewire\Component;

class HeroKpis extends Component
{

    public array $kpis = [
        [
            'label' => 'Turistas internos (año)',
            'value' => '—',
            'hint'  => 'Total estimado',
        ],
        [
            'label' => 'Llegadas internacionales (mes)',
            'value' => '—',
            'hint'  => 'Turistas + excursionistas',
        ],
        [
            'label' => 'Prestadores registrados',
            'value' => '—',
            'hint'  => '% formalización',
        ],
        [
            'label' => 'Ocupación hotelera',
            'value' => '—',
            'hint'  => 'Promedio mensual',
        ],
    ];

    public array $quickLinks = [
        ['id' => 'turismo-interno',   'label' => 'Turismo interno'],
        ['id' => 'turismo-receptivo', 'label' => 'Turismo receptivo'],
        ['id' => 'prestadores',       'label' => 'Prestadores'],
        ['id' => 'alojamientos',      'label' => 'Alojamientos'],
        ['id' => 'empleo',            'label' => 'Empleo'],
        ['id' => 'conectividad',      'label' => 'Conectividad aérea'],
    ];

    public function render()
    {
        return view('livewire.public-interface.hero-kpis');
    }
}
