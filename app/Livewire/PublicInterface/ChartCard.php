<?php

namespace App\Livewire\PublicInterface;

use Illuminate\Support\Str;
use Livewire\Component;

class ChartCard extends Component
{
    public string $title = 'Gráfico';
    public ?string $subtitle = null;

    /**
     * type: line | bar | doughnut | pie...
     * labels: []
     * datasets: [ { label, data: [], ... } ]
     */
    public string $type = 'line';
    public array $labels = [];
    public array $datasets = [];

    /** Alto del canvas (px) */
    public int $height = 260;

    /** ID único para el canvas */
    public string $chartId;

    public function mount(): void
    {
        $this->chartId = 'chart_' . Str::random(10);
    }

    protected $listeners = ['public-filters-updated' => 'onFiltersUpdated'];

    public function onFiltersUpdated($year, $month): void
    {

    }
    public function render()
    {
        return view('livewire.public-interface.chart-card');
    }
}
