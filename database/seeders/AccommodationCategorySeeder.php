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
        DB::table('accommodation_categories')->insert([
            'category' => 'Hoteles',
        ]);
        DB::table('accommodation_categories')->insert([
            'category' => 'Hostales',
        ]);
        DB::table('accommodation_categories')->insert([
            'category' => 'Posadas',
        ]);
        DB::table('accommodation_categories')->insert([
            'category' => 'Apart-hoteles',
        ]);
        DB::table('accommodation_categories')->insert([
            'category' => 'Lodges',
        ]);
    }
}
