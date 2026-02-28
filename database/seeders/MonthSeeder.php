<?php

namespace Database\Seeders;

use App\Models\Month;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MonthSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $months = [
            ['month' => 'Enero', 'month_number' => 1],
            ['month' => 'Febrero', 'month_number' => 2],
            ['month' => 'Marzo', 'month_number' => 3],
            ['month' => 'Abril', 'month_number' => 4],
            ['month' => 'Mayo', 'month_number' => 5],
            ['month' => 'Junio', 'month_number' => 6],
            ['month' => 'Julio', 'month_number' => 7],
            ['month' => 'Agosto', 'month_number' => 8],
            ['month' => 'Septiembre', 'month_number' => 9],
            ['month' => 'Octubre', 'month_number' => 10],
            ['month' => 'Noviembre', 'month_number' => 11],
            ['month' => 'Diciembre', 'month_number' => 12],
        ];

        foreach ($months as $data) {
            Month::updateOrCreate(
                ['month_number' => $data['month_number']],
                ['month' => $data['month']]
            );
        }
    }
}
