<?php

namespace Database\Seeders;

use App\Models\ServiceSector;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSectorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ServiceSector::create([
            'description' => "Alojamientos",
        ]);
        ServiceSector::create([
            'description' => "Agencias de viajes",
        ]);
        ServiceSector::create([
            'description' => "Operadores mayoristas",
        ]);
        ServiceSector::create([
            'description' => "ETC",
        ]);
    }
}
