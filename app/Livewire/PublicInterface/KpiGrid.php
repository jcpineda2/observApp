<?php

namespace App\Livewire\PublicInterface;

use Livewire\Component;

class KpiGrid extends Component
{
    public array $items = [];

    public function render()
    {
        return view('livewire.public-interface.kpi-grid');
    }
}
