<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\EntryMode;
use App\Models\EntryPoint;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EntryPointSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EntryPoint::create([
            'name' => 'Aeropuerto - Silvio Pettirossi',
            'entry_mode_id' =>  EntryMode::query()->where('name', 'like', '%Aérea%')->value('id'),
            'city_id' => City::query()->where('name', 'like', '%Luque%')->value('id'),
            'is_active' => True,
        ]);

        EntryPoint::create([
            'name' => 'Aeropuerto - Guaraní',
            'entry_mode_id' =>  EntryMode::query()->where('name', 'like', '%Aérea%')->value('id'),
            'city_id' => City::query()->where('name', 'like', '%Minga Guazú%')->value('id'),
            'is_active' => True,
        ]);

        EntryPoint::create([
            'name' => 'Aeropuerto Internacional Encarnación',
            'entry_mode_id' =>  EntryMode::query()->where('name', 'like', '%Aérea%')->value('id'),
            'city_id' => City::query()->where('name', 'like', '%Encarnación%')->value('id'),
            'is_active' => True,
        ]);

        EntryPoint::create([
            'name' => 'Aeropuerto Internacional Mcal Estigarribia',
            'entry_mode_id' =>  EntryMode::query()->where('name', 'like', '%Aérea%')->value('id'),
            'city_id' => City::query()->where('name', 'like', '%Mariscal Estigarribia%')->value('id'),
            'is_active' => True,
        ]);

        EntryPoint::create([
            'name' => 'Puerto Itá Enramada',
            'entry_mode_id' =>  EntryMode::query()->where('name', 'like', '%Fluvial%')->value('id'),
            'city_id' => City::query()->where('name', 'like', '%Asunción%')->value('id'),
            'is_active' => True,
        ]);

        EntryPoint::create([
            'name' => 'Puerto Pilar',
            'entry_mode_id' =>  EntryMode::query()->where('name', 'like', '%Fluvial%')->value('id'),
            'city_id' => City::query()->where('name', 'like', '%Pilar%')->value('id'),
            'is_active' => True,
        ]);

        EntryPoint::create([
            'name' => 'Puerto Alberdi',
            'entry_mode_id' =>  EntryMode::query()->where('name', 'like', '%Fluvial%')->value('id'),
            'city_id' => City::query()->where('name', 'like', '%Alberdi%')->value('id'),
            'is_active' => True,
        ]);
    }
}
