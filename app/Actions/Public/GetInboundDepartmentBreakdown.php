<?php

namespace App\Actions\Public;

use App\Data\Public\FiltersData;
use App\Models\State;
use App\Support\Public\InboundTourismQuery;
use Illuminate\Support\Facades\Cache;

final class GetInboundDepartmentBreakdown
{
    public function __construct(
        private readonly InboundTourismQuery $query,
    ) {}

    public function handle(FiltersData $filters, ?string $departmentKey): array
    {
        if (! $departmentKey) {
            return [
                'selectedDepartmentLabel' => null,
                'selectedDepartmentSummary' => [],
                'selectedDepartmentByCountry' => [],
            ];
        }

        $label = $this->humanizeDepartmentKey($departmentKey);

        return [
            'selectedDepartmentLabel' => $label,
            'selectedDepartmentSummary' => $this->loadSelectedDepartmentSummary($filters, $departmentKey, $label),
            'selectedDepartmentByCountry' => $this->loadSelectedDepartmentByCountry($filters, $departmentKey),
        ];
    }

    private function baseQueryForSelectedDepartment(FiltersData $filters, string $departmentKey)
    {
        $query = $this->query->base($filters);
        $departmentIds = $this->resolveSelectedDepartmentIds($departmentKey);

        if (empty($departmentIds)) {
            return $query->whereRaw('1 = 0');
        }

        return $query->whereIn('destination_department_id', $departmentIds);
    }

    private function resolveSelectedDepartmentIds(string $departmentKey): array
    {
        return Cache::remember(
            "public_inbound_tab:selected_department_ids:{$departmentKey}",
            now()->addMinutes(30),
            function () use ($departmentKey) {
                return State::query()
                    ->get(['id', 'name'])
                    ->filter(function ($state) use ($departmentKey) {
                        return $this->normalizeDepartmentKey($state->name) === $departmentKey;
                    })
                    ->pluck('id')
                    ->values()
                    ->all();
            }
        );
    }

    private function loadSelectedDepartmentByCountry(FiltersData $filters, string $departmentKey): array
    {
        $rows = $this->baseQueryForSelectedDepartment($filters, $departmentKey)
            ->leftJoin('countries', 'countries.id', '=', 'inbound_tourisms.residence_country_id')
            ->selectRaw('COALESCE(countries.name, "Sin país") as country, SUM(inbound_tourisms.tourist_arrivals) as total')
            ->groupBy('country')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        return [
            'labels' => $rows->pluck('country')->toArray(),
            'data' => $rows->pluck('total')->map(fn ($value) => (int) $value)->toArray(),
        ];
    }

    private function loadSelectedDepartmentSummary(FiltersData $filters, string $departmentKey, string $label): array
    {
        $query = $this->baseQueryForSelectedDepartment($filters, $departmentKey);

        return [
            'department' => $label,
            'tourists' => (int) (clone $query)->sum('tourist_arrivals'),
            'excursionists' => (int) (clone $query)->sum('excursionist_arrivals'),
            'foreign_exchange_revenue' => round((float) ((clone $query)->sum('foreign_exchange_revenue') ?? 0), 2),
        ];
    }

    private function humanizeDepartmentKey(?string $key): ?string
    {
        if (! $key) {
            return null;
        }

        return str($key)
            ->replace('-', ' ')
            ->title()
            ->toString();
    }

    private function normalizeDepartmentKey(?string $name): string
    {
        $normalized = mb_strtolower(trim((string) $name), 'UTF-8');

        $replacements = [
            'á' => 'a',
            'é' => 'e',
            'í' => 'i',
            'ó' => 'o',
            'ú' => 'u',
            'ü' => 'u',
            'ñ' => 'n',
            '.' => '',
            '-' => ' ',
        ];

        $normalized = strtr($normalized, $replacements);
        $normalized = preg_replace('/\s+/', ' ', $normalized);

        return match ($normalized) {
            'pdte hayes' => 'presidente hayes',
            default => $normalized,
        };
    }
}
