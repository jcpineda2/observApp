<?php

namespace App\Livewire\Public;

use App\Models\Month;
use App\Models\TourismProviderStat;
use App\Models\Year;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.public')]

class ProvidersPage extends Component
{
    public ?int $year = null;
    public ?int $month = null;

    public array $kpis = [];
    public array $registrationsCancellationsByMonth = [];
    public array $yoyStockByMonth = [];
    public array $formalizationByMonth = [];
    public array $byServiceSector = [];
    public array $byDepartment = [];

    protected $listeners = [
        'public-filters-updated' => 'onFiltersUpdated',
    ];

    public function mount(): void
    {
        if (! $this->year) {
            $this->year = Year::query()
                ->orderByDesc('year')
                ->value('id');
        }

        $this->loadAll();
    }

    public function onFiltersUpdated($year, $month): void
    {
        $this->year = $year ?: null;
        $this->month = $month ?: null;

        $this->loadAll();
    }

    private function loadAll(): void
    {
        $this->kpis = $this->loadKpis();
        $this->registrationsCancellationsByMonth = $this->loadRegistrationsCancellationsByMonth();
        $this->yoyStockByMonth = $this->loadYoYStockByMonth();
        $this->formalizationByMonth = $this->loadFormalizationByMonth();
        $this->byServiceSector = $this->loadByServiceSector();
        $this->byDepartment = $this->loadByDepartment();
    }

    private function cacheKey(string $suffix): string
    {
        return "public_providers_tab:{$suffix}:year_{$this->year}:month_" . ($this->month ?? 'all');
    }

    private function baseQuery()
    {
        return TourismProviderStat::query()
            ->when($this->year, fn ($query) => $query->where('year_id', $this->year))
            ->when($this->month, fn ($query) => $query->where('month_id', $this->month));
    }

    private function loadKpis(): array
    {
        return Cache::remember($this->cacheKey('kpis'), now()->addMinutes(10), function () {
            $query = $this->baseQuery();

            $totalRegistered = (int) (clone $query)->sum('total_registered');
            $registrations = (int) (clone $query)->sum('registrations');
            $cancellations = (int) (clone $query)->sum('cancellations');
            $formalizedTotal = (int) (clone $query)->sum('formalized_total');

            $formalizationRate = $totalRegistered > 0
                ? round(($formalizedTotal / $totalRegistered) * 100, 2)
                : 0.0;

            return [
                'total_registered' => $totalRegistered,
                'registrations' => $registrations,
                'cancellations' => $cancellations,
                'formalization_rate' => $formalizationRate,
            ];
        });
    }

    /**
     * Serie mensual: ignora el filtro de mes para mostrar todo el año.
     */
    private function loadRegistrationsCancellationsByMonth(): array
    {
        return Cache::remember(
            "public_providers_tab:registrations_cancellations_by_month:year_{$this->year}",
            now()->addMinutes(10),
            function () {
                if (! $this->year) {
                    return ['labels' => [], 'registrations' => [], 'cancellations' => []];
                }

                $months = Month::query()
                    ->orderBy('month_number')
                    ->get(['id', 'month']);

                $rows = TourismProviderStat::query()
                    ->where('year_id', $this->year)
                    ->selectRaw('month_id, SUM(registrations) as registrations_total, SUM(cancellations) as cancellations_total')
                    ->groupBy('month_id')
                    ->get()
                    ->keyBy('month_id');

                return [
                    'labels' => $months->pluck('month')->toArray(),
                    'registrations' => $months->map(fn ($month) => (int) ($rows[$month->id]->registrations_total ?? 0))->toArray(),
                    'cancellations' => $months->map(fn ($month) => (int) ($rows[$month->id]->cancellations_total ?? 0))->toArray(),
                ];
            }
        );
    }

    /**
     * Variación interanual del stock total por mes.
     */
    private function loadYoYStockByMonth(): array
    {
        return Cache::remember(
            "public_providers_tab:yoy_stock_by_month:year_{$this->year}",
            now()->addMinutes(10),
            function () {
                if (! $this->year) {
                    return [
                        'labels' => [],
                        'current' => [],
                        'previous' => [],
                        'current_year' => null,
                        'previous_year' => null,
                    ];
                }

                $selectedYearValue = (int) Year::whereKey($this->year)->value('year');
                $previousYearId = Year::query()->where('year', $selectedYearValue - 1)->value('id');

                $months = Month::query()
                    ->orderBy('month_number')
                    ->get(['id', 'month']);

                $current = TourismProviderStat::query()
                    ->where('year_id', $this->year)
                    ->selectRaw('month_id, SUM(total_registered) as total')
                    ->groupBy('month_id')
                    ->pluck('total', 'month_id');

                $previous = collect();

                if ($previousYearId) {
                    $previous = TourismProviderStat::query()
                        ->where('year_id', $previousYearId)
                        ->selectRaw('month_id, SUM(total_registered) as total')
                        ->groupBy('month_id')
                        ->pluck('total', 'month_id');
                }

                return [
                    'labels' => $months->pluck('month')->toArray(),
                    'current' => $months->map(fn ($month) => (int) ($current[$month->id] ?? 0))->toArray(),
                    'previous' => $months->map(fn ($month) => (int) ($previous[$month->id] ?? 0))->toArray(),
                    'current_year' => $selectedYearValue,
                    'previous_year' => $selectedYearValue - 1,
                ];
            }
        );
    }

    /**
     * Formalización mensual (%).
     */
    private function loadFormalizationByMonth(): array
    {
        return Cache::remember(
            "public_providers_tab:formalization_by_month:year_{$this->year}",
            now()->addMinutes(10),
            function () {
                if (! $this->year) {
                    return ['labels' => [], 'data' => []];
                }

                $months = Month::query()
                    ->orderBy('month_number')
                    ->get(['id', 'month']);

                $rows = TourismProviderStat::query()
                    ->where('year_id', $this->year)
                    ->selectRaw('month_id, SUM(total_registered) as total_registered_sum, SUM(formalized_total) as formalized_sum')
                    ->groupBy('month_id')
                    ->get()
                    ->keyBy('month_id');

                return [
                    'labels' => $months->pluck('month')->toArray(),
                    'data' => $months->map(function ($month) use ($rows) {
                        $row = $rows[$month->id] ?? null;
                        $total = (int) ($row->total_registered_sum ?? 0);
                        $formalized = (int) ($row->formalized_sum ?? 0);

                        return $total > 0
                            ? round(($formalized / $total) * 100, 2)
                            : 0;
                    })->toArray(),
                ];
            }
        );
    }

    private function loadByServiceSector(): array
    {
        return Cache::remember($this->cacheKey('by_service_sector'), now()->addMinutes(10), function () {
            $rows = $this->baseQuery()
                ->leftJoin('service_sectors', 'service_sectors.id', '=', 'tourism_provider_stats.service_sector_id')
                ->selectRaw('COALESCE(service_sectors.description, "Sin rubro") as sector, SUM(tourism_provider_stats.total_registered) as total')
                ->groupBy('sector')
                ->orderByDesc('total')
                ->get();

            return [
                'labels' => $rows->pluck('sector')->toArray(),
                'data' => $rows->pluck('total')->map(fn ($value) => (int) $value)->toArray(),
            ];
        });
    }

    private function loadByDepartment(): array
    {
        return Cache::remember($this->cacheKey('by_department'), now()->addMinutes(10), function () {
            $rows = $this->baseQuery()
                ->leftJoin('states', 'states.id', '=', 'tourism_provider_stats.state_id')
                ->selectRaw('COALESCE(states.name, "Sin departamento") as department, SUM(tourism_provider_stats.total_registered) as total')
                ->groupBy('department')
                ->orderByDesc('total')
                ->get();

            return [
                'labels' => $rows->pluck('department')->toArray(),
                'data' => $rows->pluck('total')->map(fn ($value) => (int) $value)->toArray(),
            ];
        });
    }

    public function render()
    {
        return view('livewire.public.providers-page');
    }
}
