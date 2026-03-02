<?php

namespace App\Livewire\PublicInterface\Charts;

use App\Enums\Gender as GenderEnum;
use App\Models\EmploymentDemographic;
use App\Models\Year;
use Illuminate\Support\Str;
use Livewire\Component;

class EmploymentGenderByServiceSector extends Component
{
    public ?int $year = null;
    public ?int $month = null; // anual (se ignora)

    public string $chartId;
    public string $type = 'bar';

    public array $labels = [];
    public array $datasets = [];

    protected $listeners = [
        'public-filters-updated' => 'onFiltersUpdated',
    ];

    public function mount(): void
    {
        $this->chartId = 'chart_' . Str::random(8);

        if (! $this->year) {
            $this->year = Year::query()->orderByDesc('year')->value('id');
        }

        $this->buildChart();
    }

    public function onFiltersUpdated($year, $month): void
    {
        $this->year  = $year ?: null;
        $this->month = $month ?: null; // ignorado
        $this->buildChart();
    }

    /**
     * Acepta string | Enum | null y devuelve etiqueta humana.
     */
    private function normalizeGender($g): string
    {
        if ($g instanceof GenderEnum) {
            return $g->getLabel() ?? ucfirst($g->value);
        }

        if (is_null($g) || $g === '') {
            return 'No especificado';
        }

        $v = strtolower(trim((string) $g));

        return match ($v) {
            'm', 'male', 'masculino' => 'Masculino',
            'f', 'female', 'femenino' => 'Femenino',
            default => ucfirst($v),
        };
    }

    private function buildChart(): void
    {
        if (! $this->year) {
            $this->labels = [];
            $this->datasets = [];
            $this->dispatchUpdate();
            return;
        }

        // 👇 Si tu service_sectors no tiene 'description' y usa 'name', cambiá aquí:
        $rows = EmploymentDemographic::query()
            ->leftJoin('tourism_employments', 'tourism_employments.id', '=', 'employment_demographics.tourism_employment_id')
            ->leftJoin('service_sectors', 'service_sectors.id', '=', 'tourism_employments.service_sector_id')
            ->where('tourism_employments.year_id', $this->year)
            ->selectRaw('
                COALESCE(service_sectors.description, "Sin rubro") as sector,
                employment_demographics.gender as gender,
                SUM(employment_demographics.people_count) as total
            ')
            ->groupBy('sector', 'gender')
            ->get();

        // Labels (sectores)
        $sectors = $rows->pluck('sector')->unique()->values();
        $this->labels = $sectors->toArray();

        // Géneros presentes (normalizados) — SIN casteo a string
        $genders = $rows->pluck('gender')
            ->map(fn ($g) => $this->normalizeGender($g))
            ->unique()
            ->values()
            ->toArray();

        // Matriz sector x gender
        $matrix = [];
        foreach ($sectors as $s) {
            $matrix[(string) $s] = array_fill_keys($genders, 0);
        }

        foreach ($rows as $r) {
            $sector = (string) $r->sector;
            $gender = $this->normalizeGender($r->gender);
            $matrix[$sector][$gender] = (int) $r->total;
        }

        // Datasets apilados
        $datasets = [];
        foreach ($genders as $g) {
            $datasets[] = [
                'label' => $g,
                'data' => array_map(
                    fn ($sector) => $matrix[(string) $sector][$g] ?? 0,
                    $sectors->toArray()
                ),
                'borderWidth' => 1,
            ];
        }

        $this->datasets = $datasets;

        $this->dispatchUpdate();
    }

    private function chartConfig(): array
    {
        return [
            'type' => $this->type,
            'data' => [
                'labels' => $this->labels,
                'datasets' => $this->datasets,
            ],
            'options' => [
                'responsive' => true,
                'maintainAspectRatio' => false,
                'animation' => false,
                'plugins' => [
                    'legend' => ['position' => 'bottom'],
                ],
                'scales' => [
                    'x' => [
                        'stacked' => true,
                        'grid' => ['display' => false],
                    ],
                    'y' => [
                        'stacked' => true,
                        'beginAtZero' => true,
                    ],
                ],
            ],
        ];
    }

    private function dispatchUpdate(): void
    {
        $this->dispatch('observatorio:chart:update', chartId: $this->chartId, config: $this->chartConfig());
    }

    public function render()
    {
        return view('livewire.public-interface.charts.employment-gender-by-service-sector');
    }
}
