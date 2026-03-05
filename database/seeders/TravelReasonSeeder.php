<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TravelReasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('travel_reasons')->insert([
            'description' => 'Ocio',
        ]);

        DB::table('travel_reasons')->insert([
            'description' => 'Negocios',
        ]);
        DB::table('travel_reasons')->insert([
            'description' => 'Visitas familiares',
        ]);
        DB::table('travel_reasons')->insert([
            'description' => 'Vacaciones',
        ]);
        DB::table('travel_reasons')->insert([
            'description' => 'Deportes',
        ]);
    }
}
