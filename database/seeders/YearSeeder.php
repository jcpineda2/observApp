<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class YearSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('years')->insert([
            'year' => "2021",
            'is_active' => True,
        ]);
        DB::table('years')->insert([
            'year' => "2022",
            'is_active' => True,
        ]);
        DB::table('years')->insert([
            'year' => "2023",
            'is_active' => True,
        ]);
        DB::table('years')->insert([
            'year' => "2024",
            'is_active' => True,
        ]);
    }
}
