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
            'is_active' => true,
        ]);
        AirLine::create([
            'name' => "Compañía de Aviación Paraguaya S.A. (ZP)",
            'is_active' => true,
        ]);
        AirLine::create([
            'name' => "Arolineas Argentinas (AR)",
            'is_active' => true,
        ]);
        AirLine::create([
            'name' => "Jetsmart Argentina (WJ)",
            'is_active' => true,
        ]);
        AirLine::create([
            'name' => "Air Europa (UX)",
            'is_active' => true,
        ]);
        AirLine::create([
            'name' => "Copa Airlines (CM)",
            'is_active' => true,
        ]);
        AirLine::create([
            'name' => "Empresa Pública Nacional Estratégica Boliviana de Aviación - BOA - (OB)",
            'is_active' => true,
        ]);
        AirLine::create([
            'name' => "Gol Linhas Aereas (G3)",
            'is_active' => true,
        ]);
        AirLine::create([
            'name' => "Avianca Colombia (AV)",
            'is_active' => true,
        ]);
        AirLine::create([
            'name' => "Azul Lineas Aereas Brasileiras (AD)",
            'is_active' => true,
        ]);
    }
}
