<?php

namespace Database\Seeders;

use App\Models\EntryMode;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EntryModeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EntryMode::create([
            'description' => "Vía Aérea",
        ]);

        EntryMode::create([
            'description' => "Vía Fluvial",
        ]);

        EntryMode::create([
            'description' => "Vía Terrestre",
        ]);

    }
}
