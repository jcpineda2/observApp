<?php

namespace App\Livewire\PublicInterface;

use Livewire\Component;

class KpiCard extends Component
{
    public string $title = '';
    public string $value = '';
    public ?string $subtitle = null;

    public ?string $trend = null;
    public ?string $trendDirection = null; // 'up' | 'down' | null

    public function mount(
        string $title = '',
        string $value = '',
        ?string $subtitle = null,
        ?string $trend = null,
        ?string $trendDirection = null,
    ): void {
        $this->title = $title;
        $this->value = $value;
        $this->subtitle = $subtitle;
        $this->trend = $trend;
        $this->trendDirection = $trendDirection;
    }

    public function render()
    {
        return view('livewire.public-interface.kpi-card');
    }
}
