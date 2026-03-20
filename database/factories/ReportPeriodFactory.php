<?php

namespace Database\Factories;

use App\Models\Month;
use App\Models\ReportPeriod;
use App\Models\Year;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReportPeriodFactory extends Factory
{
    protected $model = ReportPeriod::class;

    public function definition(): array
    {
        $yearId = Year::query()->inRandomOrder()->value('id') ?? Year::factory();

        $months = Month::query()
            ->orderBy('month_number')
            ->get(['id', 'month', 'month_number']);

        if ($months->count() < 12) {
            return [
                'year_id' => $yearId,
                'start_month_id' => Month::query()->value('id') ?? Month::factory(),
                'end_month_id' => Month::query()->value('id') ?? Month::factory(),
                'label' => 'Período incompleto',
                'is_full_year' => false,
            ];
        }

        $start = $months->random();
        $endCandidates = $months->where('month_number', '>=', $start->month_number);
        $end = $endCandidates->random();

        return [
            'year_id' => $yearId,
            'start_month_id' => $start->id,
            'end_month_id' => $end->id,
            'label' => "{$start->month} - {$end->month}",
            'is_full_year' => $start->month_number === 1 && $end->month_number === 12,
        ];
    }

    public function fullYear(): static
    {
        return $this->state(function () {
            $yearId = Year::query()->inRandomOrder()->value('id') ?? Year::factory();

            $start = Month::query()->where('month_number', 1)->value('id');
            $end = Month::query()->where('month_number', 12)->value('id');

            return [
                'year_id' => $yearId,
                'start_month_id' => $start,
                'end_month_id' => $end,
                'label' => 'Enero - Diciembre',
                'is_full_year' => true,
            ];
        });
    }
}
