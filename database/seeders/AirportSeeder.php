<?php

namespace Database\Seeders;

use App\Models\Airport;
use App\Models\City;
use App\Models\Country;
use App\Models\State;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AirportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Airport::create([
            'name' => "Aeropuerto Int. Silvio Pettirossi",
            'country_id' => Country::query()->where('name', 'like', '%Paraguay%')->value('id'),
            'city_id' => City::query()->where('name', 'like', '%Luque%')->whereHas('country', function ($query) {
                $query->where('name', 'like', '%Paraguay%');
            })->value('id'),
        ]);
        Airport::create([
            'name' => "Aeropuerto Int. Guarani",
            'country_id' => Country::query()->where('name', 'like', '%Paraguay%')->value('id'),
            'city_id' => City::query()->where('name', 'like', '%Minga Guazu%')->whereHas('country', function ($query) {
                $query->where('name', 'like', '%Paraguay%');
            })->value('id'),
        ]);
        Airport::create([
            'name' => "Aeropuerto Int. Teniente Amin Ayub González",
            'country_id' => Country::query()->where('name', 'like', '%Paraguay%')->value('id'),
            'city_id' => City::query()->where('name', 'like', '%Encarnación%')->whereHas('country', function ($query) {
                $query->where('name', 'like', '%Paraguay%');
            })->value('id'),
        ]);

        Airport::create([
            'name' => "Aeroparque Jorge Newbery",
            'country_id' => Country::query()->where('name', 'like', '%Argentina%')->value('id'),
            'city_id' => City::query()->where('name', 'like', '%Buenos Aires%')->whereHas('country', function ($query) {
                $query->where('name', 'like', '%argentina%');
            })->value('id'),
        ]);

        Airport::create([
            'name' => "Aeropuerto Int. Ingeniero Aeronáutico Ambrosio Taravella",
            'country_id' => Country::query()->where('name', 'like', '%Argentina%')->value('id'),
            'city_id' => City::query()->where('name', 'like', '%Córdoba%')->whereHas('country', function ($query) {
                $query->where('name', 'like', '%argentina%');
            })->value('id'),
        ]);

        Airport::create([
            'name' => "Aeropuerto Int. Viru Viru",
            'country_id' => Country::query()->where('name', 'like', '%Bolivia%')->value('id'),
            'city_id' => City::query()->where('name', 'like', '%Santa Cruz%')->whereHas('country', function ($query) {
                $query->where('name', 'like', '%Bolivia%');
            })->value('id'),
        ]);
        Airport::create([
            'name' => "Aeropuerto Int. Presidente Juscelino Kubitschek",
            'country_id' => Country::query()->where('name', 'like', '%Brazil%')->value('id'),
            'city_id' => City::query()->where('name', 'like', '%Brasilia%')->whereHas('country', function ($query) {
                $query->where('name', 'like', '%Brazil%');
            })->value('id'),
        ]);

        Airport::create([
            'name' => "Aeropuerto Int. Arturo Merino Benítez",
            'country_id' => Country::query()->where('name', 'like', '%Chile%')->value('id'),
            'city_id' => City::query()->where('name', 'like', '%Santiago%')->whereHas('country', function ($query) {
                $query->where('name', 'like', '%Chile%');
            })->value('id'),
        ]);
        Airport::create([
            'name' => "Aeropuerto Int. El Dorado",
            'country_id' => Country::query()->where('name', 'like', '%Colombia%')->value('id'),
            'city_id' => City::query()->where('name', 'like', '%Bogotá%')->whereHas('country', function ($query) {
                $query->where('name', 'like', '%Colombia%');
            })->value('id'),
        ]);

        Airport::create([
            'name' => "Aeropuerto Int. José María Córdova",
            'country_id' => Country::query()->where('name', 'like', '%Colombia%')->value('id'),
            'city_id' => City::query()->where('name', 'like', '%Medellín%')->whereHas('country', function ($query) {
                $query->where('name', 'like', '%Colombia%');
            })->value('id'),
        ]);

        Airport::create([
            'name' => "Aeropuerto Int. Rafael Núñez",
            'country_id' => Country::query()->where('name', 'like', '%Colombia%')->value('id'),
            'city_id' => City::query()->where('name', 'like', '%Cartagena%')->whereHas('country', function ($query) {
                $query->where('name', 'like', '%Colombia%');
            })->value('id'),
        ]);
        Airport::create([
            'name' => "Aeropuerto Int. Mariscal Sucre",
            'country_id' => Country::query()->where('name', 'like', '%Ecuador%')->value('id'),
            'city_id' => City::query()->where('name', 'like', '%Quito%')->whereHas('country', function ($query) {
                $query->where('name', 'like', '%Ecuador%');
            })->value('id'),
        ]);
        Airport::create([
            'name' => "Aeropuerto Int. de Carrasco",
            'country_id' => Country::query()->where('name', 'like', '%Uruguay%')->value('id'),
            'city_id' => City::query()->where('name', 'like', '%Montevideo%')->whereHas('country', function ($query) {
                $query->where('name', 'like', '%Uruguay%');
            })->value('id'),
        ]);
    }
}
