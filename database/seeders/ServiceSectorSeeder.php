<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceSectorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('service_sectors')->insert([
            'description' => "Alojamientos",
        ]);
        DB::table('service_sectors')->insert([
            'description' => "Agencias de viajes",
        ]);
        DB::table('service_sectors')->insert([
            'description' => "Operadores mayoristas",
        ]);
        DB::table('service_sectors')->insert([
            'description' => "ETC",
        ]);
    }
}
