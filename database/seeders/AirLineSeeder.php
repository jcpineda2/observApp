<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AirLineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('air_lines')->insert([
            'name' => "Transportes Aereos del Mercosur - LATAM PARAGUAY (PZ)",
        ]);
        DB::table('air_lines')->insert([
            'name' => "Compañía de Aviación Paraguaya S.A. (ZP)",
        ]);
        DB::table('air_lines')->insert([
            'name' => "Arolineas Argentinas (AR)",
        ]);
        DB::table('air_lines')->insert([
            'name' => "Jetsmart Argentina (WJ)",
        ]);
        DB::table('air_lines')->insert([
            'name' => "Air Europa (UX)",
        ]);
        DB::table('air_lines')->insert([
            'name' => "Copa Airlines (CM)",
        ]);
        DB::table('air_lines')->insert([
            'name' => "Empresa Pública Nacional Estratégica Boliviana de Aviación - BOA - (OB)",
        ]);
        DB::table('air_lines')->insert([
            'name' => "Gol Linhas Aereas (G3)",
        ]);
        DB::table('air_lines')->insert([
            'name' => "Avianca Colombia (AV)",
        ]);
        DB::table('air_lines')->insert([
            'name' => "Azul Lineas Aereas Brasileiras (AD)",
        ]);
    }
}
