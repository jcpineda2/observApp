<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EntryModeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('entry_modes')->insert([
            'description' => "Aérea",
        ]);

        DB::table('entry_modes')->insert([
            'description' => "Terrestre",
        ]);

        DB::table('entry_modes')->insert([
            'description' => "Fluvial",
        ]);

        DB::table('entry_modes')->insert([
            'description' => "Marítimo",
        ]);
    }
}
