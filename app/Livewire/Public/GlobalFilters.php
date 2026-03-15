<?php

namespace App\Livewire\Public;

use App\Models\Month;
use App\Models\Year;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;

class GlobalFilters extends Component
{
    #[Url(as: 'year', except: '')]
    public ?int $year = null;

    #[Url(as: 'month', except: '')]
    public ?int $month = null;

    public function mount(): void
    {
        $this->year ??= Year::query()->orderByDesc('year')->value('id');
    }

    public function updatedYear(): void
    {
        $this->dispatch('public-filters-updated', year: $this->year, month: $this->month);
    }

    public function updatedMonth(): void
    {
        $this->dispatch('public-filters-updated', year: $this->year, month: $this->month);
    }

    public function render()
    {
        return view('livewire.public.global-filters', [
                'years' => Year::query()->orderByDesc('year')->get(),
            'months' => Month::query()->orderBy('id')->get(),
        ]);
    }
}
