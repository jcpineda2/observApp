<?php

namespace Database\Seeders;

use App\Models\TravelReason;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TravelReasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TravelReason::create([
            'description' => 'Ocio',
        ]);

        TravelReason::create([
            'description' => 'Negocios',
        ]);
        TravelReason::create([
            'description' => 'Visitas familiares',
        ]);
        TravelReason::create([
            'description' => 'Vacaciones',
        ]);
        TravelReason::create([
            'description' => 'Deportes',
        ]);
    }
}
