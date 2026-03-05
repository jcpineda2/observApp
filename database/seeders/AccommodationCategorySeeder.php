<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccommodationCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('travel_reasons')->insert([
            'category' => 'Hoteles',
        ]);
        DB::table('travel_reasons')->insert([
            'category' => 'Hostales',
        ]);
        DB::table('travel_reasons')->insert([
            'category' => 'Posadas',
        ]);
        DB::table('travel_reasons')->insert([
            'category' => 'Apart-hoteles',
        ]);
        DB::table('travel_reasons')->insert([
            'category' => 'Lodges',
        ]);
    }
}
