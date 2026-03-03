<?php

namespace App\Livewire\PublicInterface\Controls;

use Livewire\Component;

class AirMetricToggle extends Component
{
    public string $metric = 'seats'; // seats | flights

    public function setMetric(string $metric): void
    {
        $metric = in_array($metric, ['seats', 'flights'], true) ? $metric : 'seats';

        if ($this->metric === $metric) return;

        $this->metric = $metric;

        // evento global para todos los charts/tables de conectividad aérea
        $this->dispatch('air-metric-changed', metric: $this->metric);
    }

    public function render()
    {
        return view('livewire.public-interface.controls.air-metric-toggle');
    }
}
