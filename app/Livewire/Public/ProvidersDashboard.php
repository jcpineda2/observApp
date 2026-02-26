<?php

namespace App\Livewire\Public;

use App\Models\Month;
use App\Models\ServiceSector;
use App\Models\State;
use App\Models\TourismProviderStat;
use App\Models\Year;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Url;
use Livewire\Component;

class ProvidersDashboard extends Component
{
     public ?int $year = null;

    #[Url(as: 'year_id')]
    public ?int $yearId = null;

    #[Url(as: 'month_id')]
    public ?int $monthId = null;

    #[Url(as: 'service_sector_id')]
    public ?int $serviceSectorId = null;

    #[Url(as: 'state_id')]
    public ?int $stateId = null;

    public function mount(?int $year = null): void
    {
        $this->year = $year;

        // Default: último año disponible
        $defaultYearId = Year::query()->orderByDesc('year')->value('id');

        // Si el parámetro {year} existe, intentamos mapearlo a Year::year
        if ($year) {
            $mapped = Year::query()->where('year', $year)->value('id');
            $this->yearId = $mapped ?: $defaultYearId;
        } else {
            $this->yearId = $this->yearId ?: $defaultYearId;
        }

        // Mes por defecto: ninguno (todo el año)
        $this->monthId = $this->monthId ?: null;
    }

    public function rules(): array
    {
        return [
            'yearId' => ['nullable', 'integer', Rule::exists('years', 'id')],
            'monthId' => ['nullable', 'integer', Rule::exists('months', 'id')],
            'serviceSectorId' => ['nullable', 'integer', Rule::exists('service_sectors', 'id')],
            'stateId' => ['nullable', 'integer', Rule::exists('states', 'id')],
        ];
    }

    public function updated($property): void
    {
        $this->validateOnly($property);
    }

    public function getYearsProperty()
    {
        return Year::query()->orderByDesc('year')->get();
    }

    public function getMonthsProperty()
    {
        return Month::query()->orderBy('month_number')->get();
    }

    public function getServiceSectorsProperty()
    {
        return ServiceSector::query()->orderBy('description')->get();
    }

    public function getStatesProperty()
    {
        // Si querés filtrar solo Paraguay por country->name, lo hacemos luego.
        return State::query()->orderBy('name')->get();
    }

    public function getKpisProperty(): array
    {
        $this->validate(); // validación global antes de consultar

        $cacheKey = 'public:providers:kpis:' . implode(':', [
            $this->yearId ?: 'all',
            $this->monthId ?: 'all',
            $this->serviceSectorId ?: 'all',
            $this->stateId ?: 'all',
        ]);

        return Cache::remember($cacheKey, now()->addMinutes(5), function () {
            $base = TourismProviderStat::query()
                ->when($this->yearId, fn ($q) => $q->where('year_id', $this->yearId))
                ->when($this->monthId, fn ($q) => $q->where('month_id', $this->monthId))
                ->when($this->serviceSectorId, fn ($q) => $q->where('service_sector_id', $this->serviceSectorId))
                ->when($this->stateId, fn ($q) => $q->where('state_id', $this->stateId));

            $total = (int) (clone $base)->sum('total_registered');
            $registrations = (int) (clone $base)->sum('registrations');
            $cancellations = (int) (clone $base)->sum('cancellations');
            $formalized = (int) (clone $base)->sum('formalized_total');

            $formalizationRate = $total > 0
                ? round(($formalized / $total) * 100, 1)
                : 0.0;

            // Variación interanual: compara contra mismo filtro del año anterior (por Year::year)
            $yoy = null;

            if ($this->yearId) {
                $currentYear = Year::query()->find($this->yearId);
                if ($currentYear) {
                    $prevYearId = Year::query()->where('year', $currentYear->year - 1)->value('id');

                    if ($prevYearId) {
                        $prev = TourismProviderStat::query()
                            ->where('year_id', $prevYearId)
                            ->when($this->monthId, fn ($q) => $q->where('month_id', $this->monthId))
                            ->when($this->serviceSectorId, fn ($q) => $q->where('service_sector_id', $this->serviceSectorId))
                            ->when($this->stateId, fn ($q) => $q->where('state_id', $this->stateId))
                            ->sum('total_registered');

                        $prev = (int) $prev;

                        $yoy = $prev > 0
                            ? round((($total - $prev) / $prev) * 100, 1)
                            : null;
                    }
                }
            }

            return [
                'total' => $total,
                'registrations' => $registrations,
                'cancellations' => $cancellations,
                'formalization_rate' => $formalizationRate,
                'yoy_variation' => $yoy,
            ];
        });
    }


    public function render()
    {
        return view('livewire.public.providers-dashboard')
            ->layout('layouts.public', ['title' => 'Prestadores de Servicios Turísticos']);
    }
}
