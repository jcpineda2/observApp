<?php

namespace Database\Seeders;

use App\Models\AirLine;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AirLineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AirLine::create([
            'name' => "Transportes Aereos del Mercosur - LATAM PARAGUAY (PZ)",
        ]);
        AirLine::create([
            'name' => "Compañía de Aviación Paraguaya S.A. (ZP)",
        ]);
        AirLine::create([
            'name' => "Arolineas Argentinas (AR)",
        ]);
        AirLine::create([
            'name' => "Jetsmart Argentina (WJ)",
        ]);
        AirLine::create([
            'name' => "Air Europa (UX)",
        ]);
        AirLine::create([
            'name' => "Copa Airlines (CM)",
        ]);
        AirLine::create([
            'name' => "Empresa Pública Nacional Estratégica Boliviana de Aviación - BOA - (OB)",
        ]);
        AirLine::create([
            'name' => "Gol Linhas Aereas (G3)",
        ]);
        AirLine::create([
            'name' => "Avianca Colombia (AV)",
        ]);
        AirLine::create([
            'name' => "Azul Lineas Aereas Brasileiras (AD)",
        ]);
    }
}
