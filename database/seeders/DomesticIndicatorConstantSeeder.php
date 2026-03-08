<?php

namespace Database\Seeders;

use App\Enums\IndicatorDomain;
use App\Enums\IndicatorKey;
use App\Models\IndicatorConstant;
use App\Models\Year;
use Illuminate\Database\Seeder;

class DomesticIndicatorConstantSeeder extends Seeder
{
    public function run(): void
    {
        $years = Year::query()->pluck('id', 'year');

        if ($years->isEmpty()) {
            return;
        }

        foreach ($years as $yearValue => $yearId) {
            $rows = [
                [
                    'key' => IndicatorKey::AvgSpendFixed->value,
                    'value' => fake()->randomFloat(2, 150000, 800000),
                    'label' => IndicatorKey::AvgSpendFixed->getLabel(),
                    'unit' => 'Gs.',
                    'source' => 'Valor fijo de referencia',
                    'notes' => null,
                ],
                [
                    'key' => IndicatorKey::AvgStayFixed->value,
                    'value' => fake()->randomFloat(2, 1, 7),
                    'label' => IndicatorKey::AvgStayFixed->getLabel(),
                    'unit' => 'noches',
                    'source' => 'Valor fijo de referencia',
                    'notes' => null,
                ],
                [
                    'key' => IndicatorKey::ExpenseCompositionFood->value,
                    'value' => 25.00,
                    'label' => IndicatorKey::ExpenseCompositionFood->getLabel(),
                    'unit' => '%',
                    'source' => 'Composición fija del gasto',
                    'notes' => null,
                ],
                [
                    'key' => IndicatorKey::ExpenseCompositionLodging->value,
                    'value' => 30.00,
                    'label' => IndicatorKey::ExpenseCompositionLodging->getLabel(),
                    'unit' => '%',
                    'source' => 'Composición fija del gasto',
                    'notes' => null,
                ],
                [
                    'key' => IndicatorKey::ExpenseCompositionTransport->value,
                    'value' => 20.00,
                    'label' => IndicatorKey::ExpenseCompositionTransport->getLabel(),
                    'unit' => '%',
                    'source' => 'Composición fija del gasto',
                    'notes' => null,
                ],
                [
                    'key' => IndicatorKey::ExpenseCompositionShopping->value,
                    'value' => 15.00,
                    'label' => IndicatorKey::ExpenseCompositionShopping->getLabel(),
                    'unit' => '%',
                    'source' => 'Composición fija del gasto',
                    'notes' => null,
                ],
                [
                    'key' => IndicatorKey::ExpenseCompositionOther->value,
                    'value' => 10.00,
                    'label' => IndicatorKey::ExpenseCompositionOther->getLabel(),
                    'unit' => '%',
                    'source' => 'Composición fija del gasto',
                    'notes' => null,
                ],
            ];

            foreach ($rows as $row) {
                IndicatorConstant::updateOrCreate(
                    [
                        'domain' => IndicatorDomain::Domestic->value,
                        'key' => $row['key'],
                        'year_id' => $yearId,
                    ],
                    [
                        'value' => $row['value'],
                        'label' => $row['label'],
                        'unit' => $row['unit'],
                        'source' => $row['source'],
                        'notes' => $row['notes'],
                    ]
                );
            }
        }
    }
}
