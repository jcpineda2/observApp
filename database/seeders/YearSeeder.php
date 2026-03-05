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
        ]);
        DB::table('years')->insert([
            'year' => "2022",
        ]);
        DB::table('years')->insert([
            'year' => "2023",
        ]);
        DB::table('years')->insert([
            'year' => "2024",
        ]);
    }
}
