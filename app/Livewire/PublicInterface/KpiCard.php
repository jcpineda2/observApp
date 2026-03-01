<?php

namespace App\Livewire\PublicInterface;

use Livewire\Component;

class KpiCard extends Component
{
    public string $title;
    public string $value;
    public ?string $subtitle = null;
    public ?string $trend = null; // ejemplo: +5.4% o -2.1%
    public ?string $trendDirection = null; // up | down | neutral

    public function render()
    {
        return view('livewire.public-interface.kpi-card');
    }
}
